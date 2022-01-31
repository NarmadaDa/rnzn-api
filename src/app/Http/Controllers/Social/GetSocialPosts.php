<?php

namespace App\Http\Controllers\Social;

use App\Http\Controllers\PaginatedController;
use App\Http\Requests\Social\GetSocialPostsRequest;
use App\Models\SocialAccount;
use App\Models\SocialPost;
use Http;
use Log;

class GetSocialPosts extends PaginatedController
{
  /**
   * Handle the incoming request.
   *
   * @param  \App\Http\Requests\Social\GetSocialPostsRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function __invoke(GetSocialPostsRequest $request)
  {
    Log::info("-> GetSocialPosts");

    $data = $request->validated();
    $ids = [];
    $page = 1;
    $perPage = 10;

    if (isset($data["social_accounts"])) {
      $ids = $data["social_accounts"];
    }

    if (count($ids) == 0) {
      $ids = SocialAccount::pluck("id")->toArray();
    }

    if (array_key_exists("page", $data)) {
      $page = $data["page"];
    }

    $posts = SocialPost::whereIn("social_account_id", $ids)
      ->orderByDesc("posted_at")
      ->with(["account", "media"]);
    $paginated = $posts->paginate($perPage);

    // return list of filtered posts
    return $this->paginate("social_posts", $paginated);
  }
}
