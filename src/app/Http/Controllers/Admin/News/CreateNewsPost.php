<?php

namespace App\Http\Controllers\Admin\News;

use App\Http\Controllers\News\BasePostController;
use App\Http\Requests\News\CreateNewsPostRequest;
use App\Events\NewsPostCreated;

class CreateNewsPost extends BasePostController
{
  /**
   * Handle the incoming request.
   *
   * @param  \App\Http\Requests\News\CreateNewsPostRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function __invoke(CreateNewsPostRequest $request)
  {
    $data = $request->validated();

    $postType = $this->postTypeRepository->findByType($data["type"]);
    if (!$postType) {
      abort(400, "Invalid Type.");
    }

    $post = $this->postRepository->create([
      "title" => $data["title"],
      "post_type_id" => $postType->id,
      "content" => $data["content"],
    ]);

    $post->fresh()->with("type");

    NewsPostCreated::dispatch($post);

    return [
      "post" => $post,
    ];
  }
}
