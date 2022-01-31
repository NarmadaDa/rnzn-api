<?php

namespace App\Http\Controllers\Admin\News;

use App\Http\Controllers\PaginatedController;
use App\Models\Post;
use Illuminate\Http\Request;

class SearchPosts extends PaginatedController
{
  /**
   * Handle the incoming request.
   *
   * @param  Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function __invoke(Request $request)
  {
    // $size = $request->get("page_size", 10);

    $posts = Post::with(["media"]);

    if (!empty(($search = $request->get("s")))) {
      // case-insensitive search
      $posts->where("title", "ILIKE", "%$search%");
    }

    return $this->paginate(
      "posts",
      $posts->orderByDesc("updated_at")->paginate(10000)
    );
  }
}
