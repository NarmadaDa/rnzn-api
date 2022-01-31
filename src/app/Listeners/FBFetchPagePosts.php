<?php

namespace App\Listeners;

use App\Events\Interfaces\FBPageEvent;
use App\Events\FBFetchedPagePosts;
use App\Models\Media;
use App\Models\SocialPost;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use DB;
use Log;

class FBFetchPagePosts implements ShouldQueue
{
  /**
   * Handle the event.
   *
   * @param  \App\Events\Interfaces\FBPageEvent  $event
   * @return void
   */
  public function handle(FBPageEvent $event)
  {
    $account = $event->account;
    if (!$account) {
      return;
    }

    $session = $account->sessions()->first();
    if (!$session) {
      Log::error("Failed to find valid Session for FB Page '".$account->name."'");
      return;
    }

    $timestamp = Carbon::now()->timestamp;
    if ($event->oldestPost) {
      $timestamp = $event->oldestPost->unixtimestamp();
    }

    $baseDate = Carbon::createFromFormat("d-m-Y", "01-01-2020")->timestamp;
    if ($timestamp < $baseDate) {
      // don't go further back than 1st Jan 2020
      return;
    }

    $url =
      "https://graph.facebook.com/v9.0/me/published_posts" .
      "?fields=id,created_time,status_type,message,permalink_url" .
      ",attachments{url,media_type,media,subattachments}" .
      "&limit=100" .
      "&until=" .
      $timestamp .
      "&access_token=" .
      $session->long_lived_page_token;

    $response = Http::get($url);
    $json = $response->json();

    if (!isset($json["data"])) {
      return;
    }

    DB::beginTransaction();

    $oldestPost = null;
    $anotherOne = count($json["data"]) == 100 && $timestamp > $baseDate;

    try {
      foreach ($json["data"] as $p) {
        if (empty($p["status_type"])) {
          continue;
        }

        $content = "";
        if (!empty($p["message"])) {
          $content = $p["message"];
        }

        $postDate = Carbon::parse($p["created_time"]);
        if ($postDate->timestamp < $baseDate) {
          $anotherOne = false;
          continue;
        }

        $exists = SocialPost::where('post_id', $p["id"])->exists();
        if ($exists) {
          $anotherOne = false;
          continue;
        }

        $post = SocialPost::firstOrCreate(
          [
            "social_account_id" => $account->id,
            "post_id" => $p["id"],
            "post_url" => $p["permalink_url"],
          ],
          [
            "type" => $p["status_type"],
            "content" => $content,
            "posted_at" => $postDate,
          ]
        );
        Log::info("<-- FBFetchPagePosts - Cached post: ".$p["id"]);

        // if the post doesn't have any attachments
        if (!array_key_exists("attachments", $p)) {
          continue;
        }

        foreach ($p["attachments"]["data"] as $a) {
          // if the attachment doesn't have any media
          if (!array_key_exists("media", $a)) {
            continue;
          }

          $type = $a["media_type"];
          if ($type === "album" && array_key_exists("subattachments", $a)) {
            foreach ($a["subattachments"]["data"] as $s) {
              $thumbnail = $s["media"]["image"]["src"];
              $url = $thumbnail;
              if (array_key_exists("source", $s["media"])) {
                $url = $s["media"]["source"];
              }
              Media::firstOrCreate([
                "mediable_type" => "social_post",
                "mediable_id" => $post->id,
                "type" => $s["type"],
                "url" => $url,
                "thumbnail_url" => $thumbnail,
              ]);
            }
          } else {
            $thumbnail = $a["media"]["image"]["src"];
            $url = $thumbnail;
            if (array_key_exists("source", $a["media"])) {
              $url = $a["media"]["source"];
            }

            Media::firstOrCreate([
              "mediable_type" => "social_post",
              "mediable_id" => $post->id,
              "type" => $type,
              "url" => $url,
              "thumbnail_url" => $thumbnail,
            ]);
          }
        }

        if (!$anotherOne) {
          continue;
        }

        if (
          !$oldestPost ||
          $post->unixtimestamp() < $oldestPost->unixtimestamp()
        ) {
          $oldestPost = $post;
        }
      }
      
      DB::commit();
    } catch (Exception $e) {
      Log::warning("An error occurred updating Posts for FB Page '".$account->name."'");
      Log::error($e);
      DB::rollback();
      return;
    }

    if ($anotherOne) {
      Log::info("oldestPostTimestamp=" . $oldestPost->unixtimestamp());
      FBFetchedPagePosts::dispatch($account, $oldestPost);
    }
  }
}
