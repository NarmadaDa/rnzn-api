<?php

namespace App\Http\Controllers\Admin\Article;

use App\Http\Controllers\Article\BaseArticleController;
use App\Http\Requests\Article\DeleteArticleRequest;
use App\Models\Article;
use DB;

class DeleteArticle extends BaseArticleController
{
  /**
   * Handle the incoming request.
   *
   * @param  \App\Http\Requests\Article\DeleteArticleRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function __invoke(DeleteArticleRequest $request)
  {
    $data = $request->validated();

    $article = $this->articleRepository->findByUUID($data["uuid"]);
    if (!$article) {
      abort(404, "Article does not exist.");
    }

    $menuItems = $this->menuItemRepository->getItemsForArticleItemById(
      $article->id
    );

    DB::transaction(function () use ($article, $menuItems) {
      $article->delete();
      if ($menuItems->count()) {
        $menuItems->each->delete();
      }
    });

    return [
      "message" => "Article successfully deleted.",
    ];
  }
}
