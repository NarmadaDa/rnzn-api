<?php

namespace App\Http\Controllers\Admin\Article;

use Illuminate\Validation\ValidationException;
use App\Http\Requests\Article\UpdateArticleRequest;
use App\Http\Controllers\Article\BaseArticleController;
use App\Models\Role;
use App\Models\Media;
use DB;
use Validator;

class UpdateArticle extends BaseArticleController
{
  /**
   * Handle the incoming request.
   *
   * @param  \App\Http\Requests\Article\UpdateArticleRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function __invoke(UpdateArticleRequest $request)
  {
    $data = $request->validated();

    $article = $this->articleRepository->findByUUID($data["uuid"]);
    if (!$article) {
      abort(404, "Article does not exist.");
    }

    $sameSlug = $this->articleRepository->findBySlug($data["slug"]);
    if ($sameSlug && $article->id !== $sameSlug->id) {
      $validator = Validator::make([], []);
      $validator->errors()->add("slug", "Slug already exists.");
      throw new ValidationException($validator);
    }

    DB::beginTransaction();

    try {
      $article->title = $data["title"];
      $article->slug = $data["slug"];
      $article->content = $data["content"];
      $article->keywords = $data["keywords"];
      $article->save();

      $roleIds = Role::whereIn("slug", $data["roles"])
        ->pluck("id")
        ->toArray();
      $article->roles()->sync($roleIds);

      // If no banner is passed through we will remove the existing banner
      if (empty($data["banner"])) {
        $article
          ->media()
          ->where("type", "=", "banner")
          ->delete();
      } elseif (!empty($data["banner"])) {
        // check if already same image attached
        $banner = $article
          ->media()
          ->where("type", "=", "banner")
          ->where("url", "=", $data["banner"])
          ->first();

        // If no banner is found, we will delete the old one and attach a new one
        if ($banner == null) {
          $article
            ->media()
            ->where("type", "=", "banner")
            ->delete();
          $article->media()->create([
            "type" => "banner",
            "url" => $data["banner"],
            "thumbnail_url" => $data["banner"],
          ]);
        }
      }
    } catch (\Exception $e) {
      DB::rollback();
      abort(500, $e->getMessage());
    }

    DB::commit();

    return [
      "article" => $article->fresh()->load(["roles", "media"]),
    ];
  }
}
