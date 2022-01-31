<?php

namespace App\Http\Controllers\Admin\Article;

use App\Http\Controllers\PaginatedController;
use App\Models\Article;
use Illuminate\Http\Request;

class GetArticles extends PaginatedController
{
  /**
   * Handle the incoming request.
   *
   * @param  Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function __invoke(Request $request)
  {
    $articles = Article::with(["roles", "media"]);

    if (!empty(($search = $request->get("s")))) {
      $articles->where("title", "ilike", "%$search%");
    }

    $paginated = $articles->orderBy('created_at', 'desc')->paginate(10000);

    return $this->paginate("articles", $paginated);
  }
}
