<?php

namespace App\Http\Controllers\Admin\Article;

use App\Http\Controllers\Article\BaseArticleController;
use App\Http\Requests\Article\CreateArticleRequest;
use App\Models\Article;
use Exception;
use Illuminate\Support\Facades\DB;

class CreateArticle extends BaseArticleController
{
  /**
   * Handle the incoming request.
   *
   * @param  \App\Http\Requests\Article\CreateArticleRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function __invoke(CreateArticleRequest $request)
  {
    $data = $request->validated();  

    DB::beginTransaction();

    $article; $max_shortlist = null;

    try {

      if($data["shortlist"]){ 
        $max_shortlist = Article::max("shortlist_order");
        if(!$max_shortlist){
          $max_shortlist = 1;  
        } else {
          $max_shortlist +=1;
        } 
      }

      $article = $this->articleRepository->create([
        "title" => $data["title"],
        "slug" => $data["slug"],
        "content" => $data["content"],
        "keywords" => $data["keywords"],
        "summary" => $data["summary"],
        "banner" => $data["banner"],
        "shortlist" => $data["shortlist"], 
        "shortlist_order" => $max_shortlist,   
      ]);

      foreach ($data["roles"] as $r) {
        $role = $this->roleRepository->findBySlug($r);
        $article->roles()->attach($role);
      }
 
    } catch (Exception $e) {
      DB::rollback();
      abort(500, $e->getMessage());
    }

    DB::commit();
 
    $refreshed = $article->fresh()->load(["roles"]);

    return [
      "article" => $refreshed,
    ];
    
  }
}
