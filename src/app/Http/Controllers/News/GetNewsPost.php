<?php

namespace App\Http\Controllers\News;

use App\Http\Controllers\News\BasePostController;
use App\Http\Requests\News\GetNewsPostRequest;

class GetNewsPost extends BasePostController
{
  /**
   * Handle the incoming request.
   *
   * @param  \App\Http\Requests\News\GetNewsPostRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function __invoke(GetNewsPostRequest $request)
  {
    $data = $request->validated();
    
    $post = $this->postRepository->findByUUID($data['uuid']);
    if (!$post)
    {
      abort(404, 'Post does not exist.');
    }
    
    return [
      'post' => $post,
    ];
  }
}
