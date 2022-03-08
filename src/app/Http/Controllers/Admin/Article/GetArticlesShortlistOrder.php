<?php

namespace App\Http\Controllers\Admin\Article;

use App\Http\Controllers\Article\BaseArticleController;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Http\Resources\ArticalResource;

class GetArticlesShortlistOrder extends BaseArticleController
{
  /**
   * Handle the incoming request.
   *
   * @param  void
   * @return \Illuminate\Http\Response
   */
  public function __invoke(Request $request)
  {
    // Get the user from the request...
    $user = $request->user(); 

    // Get the shortlisted articles...
      $articles = ArticalResource::collection(Article::where('shortlist', true)->orderBy('shortlist_order','asc')->get()); 

    return [
      "article_shortlist" => $articles,
    ];
  }
}
