<?php

namespace App\Http\Controllers\Article;

use App\Http\Controllers\Article\BaseArticleController;
use Illuminate\Http\Request;
use App\Models\Article;

class GetArticlesShortlist extends BaseArticleController
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
    $allow_role_ids = [];
    if($user->isAdmin()){   
      $allow_role_ids = [1,2,3,5];
    } else if($user->isPersonnel()){
      $allow_role_ids = [3, 5];
    } else { // guest
      $allow_role_ids = [5];
    }

    $articles = Article::with(["roles", "media"])->where('shortlist', true)->whereHas('roles', function($query) use($allow_role_ids){
     $query->whereIn('id', $allow_role_ids); 
    })->orderBy('shortlist_order','desc')->get(); 


    // If there are no shortlisted articles, return a a dozen random public articles...
    if (!$articles || null === $articles || $articles->isEmpty()) {

      $articles = Article::whereHas('roles', function($query){ $query->where('slug','guest'); })->inRandomOrder()->limit(12)->get();

      return [
        "article_shortlist" => $articles,
      ];
    }
    
    // Return the authorised articles shortlist collection...
    return [
      "article_shortlist" => $articles,
    ];
  }
}
