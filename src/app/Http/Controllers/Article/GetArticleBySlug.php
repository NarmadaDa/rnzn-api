<?php

namespace App\Http\Controllers\Article;

use App\Http\Controllers\Article\BaseArticleController;
use App\Http\Requests\Article\GetArticleBySlugRequest;
use App\Models\Article;

class GetArticleBySlug extends BaseArticleController
{
  /**
   * Handle the incoming request.
   *
   * @param  \App\Http\Requests\Article\GetArticleBySlugRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function __invoke(GetArticleBySlugRequest $request)
  {
    $data = $request->validated();
    $user = $request->user();

    $article = $this->articleRepository->findBySlug($data["slug"]);
    if (!$article) {
      abort(404, "Article does not exist.");
    }

    $ids = $article
      ->roles()
      ->pluck("id")
      ->toArray();

    $authorised = $user
      ->roles()
      ->whereIn("id", $ids)
      ->exists();

    if (!$authorised) {
      abort(401, "Unauthorised.");
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
