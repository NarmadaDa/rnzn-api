<?php

namespace App\Http\Controllers\Article;

use App\Http\Requests\Article\SubmitArticleFeedbackRequest;
use App\Http\Controllers\Article\BaseArticleController;
use App\Models\ArticleFeedback;

class SubmitArticleFeedback extends BaseArticleController
{
  /**
   * Handle the incoming request.
   *
   * @param  \App\Http\Requests\Article\SubmitArticleFeedbackRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function __invoke(SubmitArticleFeedbackRequest $request)
  {
    $data = $request->validated();
    $user = $request->user();
    
    $article = $this->articleRepository->findByUUID($data['uuid']);
    if (!$article)
    {
      abort(404, 'Article does not exist.');
    }

    $feedback = ArticleFeedback::where('article_id', $article->id)
      ->where('user_id', $user->id)
      ->first();

    if (!$feedback)
    {
      // create new feedback record if it doesn't exist
      $feedback = ArticleFeedback::create([
        'article_id' => $article->id,
        'user_id' => $user->id,
        'rating' => $data['rating'],
      ]);
    }
    else if ($feedback->rating != $data['rating'])
    {
      // only update feedback record if rating is different
      $feedback->rating = $data['rating'];
      $feedback->save();
    }

    return [
      'feedback' => $feedback,
    ];
  }
}
