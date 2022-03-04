<?php

namespace App\Http\Controllers\Admin\Article;

use App\Http\Controllers\Article\BaseArticleController;
use App\Http\Requests\Article\DeleteArticleShortlistRequest;
use App\Models\Article;
use DB;

class DeleteArticleShortlist extends BaseArticleController
{
  /**
   * Handle the incoming request.
   *
   * @param  \App\Http\Requests\Article\DeleteArticleShortlistRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function __invoke(DeleteArticleShortlistRequest $request)
  { 
    $data = $request->validated();

    $article = $this->articleRepository->findByUUID($data["uuid"]);
    if (!$article) {
      abort(404, "Article does not exist.");
    } 

    DB::beginTransaction();

    try { 
      $article->shortlist = 0;
      $article->shortlist_order = null;
      $article->save(); 

    } catch (\Exception $e) {
      DB::rollback();
      abort(500, $e->getMessage());
    }

    DB::commit();

    // Article::where('uuid', $data["uuid"])->update(['shortlist' => null, 'shortlist_order' => null]);  

    return [
      "message" => "Article shortlist successfully deleted.",
    ];
  }
}
