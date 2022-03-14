<?php

namespace App\Http\Controllers\Admin\News;

use App\Http\Controllers\News\BasePostController;
use App\Http\Requests\News\UpdateNewsPostRequest;
use App\Models\Post;
use Illuminate\Validation\ValidationException;
use Validator;

class UpdateNewsPost extends BasePostController
{
  /**
   * Handle the incoming request.
   *
   * @param  \App\Http\Requests\News\UpdateNewsPostRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function __invoke(UpdateNewsPostRequest $request)
  {
    $data = $request->validated();

    $post = $this->postRepository->findByUUID($data["uuid"]);
    if (!$post) {
      abort(404, "Post does not exist.");
    }

    $postType = $this->postTypeRepository->findByType($data["type"]);
    if (!$postType) {
      abort(400, "Invalid Type.");
    }

    $post->title = $data["title"];
    $post->content = $data["content"];
    $post->post_type_id = $postType->id;
    $post->summary = $data["summary"];
    $post->banner = $data["banner"];
    $post->save();

    $post->fresh();
    $post->load("type");

    return [
      "post" => $post,
    ];
  }
}
