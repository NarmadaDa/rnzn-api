<?php

namespace App\Http\Controllers\Admin\News;

use App\Http\Controllers\News\BasePostController;
use App\Http\Requests\News\DeleteNewsPostRequest;
use App\Models\Notification;

class DeleteNewsPost extends BasePostController
{
  /**
   * Handle the incoming request.
   *
   * @param  \App\Http\Requests\News\DeleteNewsPostRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function __invoke(DeleteNewsPostRequest $request)
  {
    $data = $request->validated();

    $post = $this->postRepository->findByUUID($data["uuid"]);
    if (!$post) {
      abort(404, "Post does not exist.");
    }

    Notification::where('item_type', '=', 'news_post')
      ->where('item_id', $post->id)
      ->delete();

    $post->delete();

    return [
      "message" => "Post successfully deleted.",
    ];
  }
}
