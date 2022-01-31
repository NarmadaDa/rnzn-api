<?php

use App\Models\Media;
use App\Models\SocialAccount;
use App\Models\SocialPost;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class SocialSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $file = File::get("database/data/social.json");
    $data = json_decode($file);

    foreach ($data as $o) {
      $account = SocialAccount::create([
        "type" => "facebook_page",
        "social_id" => $o->social_id,
        "name" => $o->name,
      ]);

      foreach ($o->posts as $p) {
        $post = SocialPost::create([
          "social_account_id" => $account->id,
          "post_id" => $p->id,
          "post_url" => $p->url,
          "content" => $p->content,
          "type" => $p->type,
          "posted_at" => $p->posted_at,
        ]);

        foreach ($p->media as $m) {
          $media = Media::create([
            "mediable_type" => "social_post",
            "mediable_id" => $post->id,
            "type" => $m->type,
            "thumbnail_url" => $m->url,
            "url" => $m->url,
          ]);
        }
      }
    }
  }
}
