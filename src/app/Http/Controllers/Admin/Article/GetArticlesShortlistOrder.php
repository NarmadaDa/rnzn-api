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
      $articles = ArticalResource::collection(Article::where('shortlist', true)->orderBy('shortlist_order','desc')->get()); 

    // If there are no shortlisted articles, return a a dozen random public articles...
    if (!$articles || null === $articles || $articles->isEmpty()) {  

      $articles = Article::whereHas('roles', function($query){ $query->where('slug','guest'); })->inRandomOrder()->limit(12)->get();

      return [
        "article_shortlist" => $articles,
      ];
    }

    // Filter the articles by role...
    $authorisedArticles = $articles->map(function($article) use ($user){

      $ids = $article->roles()->pluck('id')->toArray();

      $authorised = $user->roles()->whereIn('id', $ids)->exists();

      if ($authorised){

        return $article;
      }
    });

    // Return the authorised articles shortlist collection...
    return [
      "article_shortlist" => $authorisedArticles,
    ];
  }
}
