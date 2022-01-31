<?php

namespace App\Http\Controllers\Admin\Social;

use App\Http\Controllers\PaginatedController;
use App\Models\SocialAccount;
use Illuminate\Http\Request;

class FBGetPosts extends PaginatedController
{
  /**
   * Handle the incoming request.
   *
   * @param  Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function __invoke($uuid, Request $request)
  {
    $perPage = $request->get("page_size", 10);
    $account = SocialAccount::where("uuid", $uuid)->first();
    if (!$account) {
      abort(404, "Invalid Social Account.");
    }

    $paginated = $account
      ->posts()
      ->orderBy("posted_at", "desc")
      ->paginate($perPage);

    return $this->paginate("social_posts", $paginated);
  }
}
