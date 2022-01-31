<?php

namespace App\Http\Controllers\Article;

use App\Http\Controllers\Article\BaseArticleController;
use App\Http\Requests\Article\DownloadArticleRequest;
use App\Events\ArticleDownloadRequested;
use App\Mail\ArticleDownloadEmail;
use Mail;

class DownloadArticle extends BaseArticleController
{
  /**
   * Handle the incoming request.
   *
   * @param  \App\Http\Requests\Article\DownloadArticleRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function __invoke(DownloadArticleRequest $request)
  {
    $data = $request->validated();
    $user = $request->user();

    $article = $this->articleRepository->findByUUID($data["uuid"]);
    if (!$article) {
      abort(404, "Article does not exist.");
    }

    // TODO: migrate this to a queued Azure function to reduce load
    // ArticleDownloadRequested::dispatch($article);

    $email = new ArticleDownloadEmail($article);
    $result = Mail::to($user)->send($email);

    return [
      "message" => "You will be emailed a copy of this article.",
    ];
  }
}
