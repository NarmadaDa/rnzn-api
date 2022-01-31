<?php

namespace App\Http\Controllers\Article;

use App\Http\Requests\Article\ReportArticleRequest;
use App\Http\Controllers\Article\BaseArticleController;
use App\Models\ArticleReport;

class ReportArticle extends BaseArticleController
{
  /**
   * Handle the incoming request.
   *
   * @param  \App\Http\Requests\Article\ReportArticleRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function __invoke(ReportArticleRequest $request)
  {
    $data = $request->validated();
    $user = $request->user();

    $article = $this->articleRepository->findByUUID($data["uuid"]);
    if (!$article) {
      abort(404, "Article does not exist.");
    }

    // create report if it doesn't exist
    $report = ArticleReport::create([
      "article_id" => $article->id,
      "user_id" => $user->id,
      "message" => $data["message"],
    ]);

    return [
      "report" => $report,
    ];
  }
}
