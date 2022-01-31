<?php

namespace App\Http\Controllers\News;

use App\Http\Controllers\News\BasePostController;

class GetAllNewsPosts extends BasePostController
{
  /**
   * Handle the incoming request.
   *
   * @return \Illuminate\Http\Response
   */
  public function __invoke()
  {    
    // TODO: paginate
    $posts = $this->postRepository->all();
    
    return [
      'posts' => $posts,
    ];
  }
}
