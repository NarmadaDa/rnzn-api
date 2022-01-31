<?php

namespace App\Http\Controllers\Admin\Article;

use App\Http\Controllers\Article\BaseArticleController;
use Illuminate\Http\Request;

class GetArticleByUUID extends BaseArticleController
{
  /**
   * Handle the incoming request.
   *
   * @param  Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function __invoke(Request $request)
  {
    $user = $request->user();
    $uuid = $request->route("uuid");

    $article = $this->articleRepository->findByUUID($uuid);
    if (!$article) {
      abort(404, "Article does not exist.");
    }

    $feedback = $user
      ->articleFeedback()
      ->where("article_id", $article->id)
      ->first();

    if ($feedback) {
      $article->feedback = $feedback;
    }

    return [
      "article" => $article,
    ];
  }
}
