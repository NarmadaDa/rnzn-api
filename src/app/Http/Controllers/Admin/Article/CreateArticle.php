<?php

namespace App\Http\Controllers\Admin\Article;

use App\Http\Controllers\Article\BaseArticleController;
use App\Http\Requests\Article\CreateArticleRequest;
use App\Models\Article;
use Exception;
use Illuminate\Support\Facades\DB;

class CreateArticle extends BaseArticleController
{
  /**
   * Handle the incoming request.
   *
   * @param  \App\Http\Requests\Article\CreateArticleRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function __invoke(CreateArticleRequest $request)
  {
    $data = $request->validated();  

    DB::beginTransaction();

    $article = null;

    try {
      $article = $this->articleRepository->create([
        "title" => $data["title"],
        "slug" => $data["slug"],
        "content" => $data["content"],
        "keywords" => $data["keywords"],
      ]);

      foreach ($data["roles"] as $r) {
        $role = $this->roleRepository->findBySlug($r);
        $article->roles()->attach($role);
      }


      if (!empty($data["banner"])) {
        $article->media()->create([
          "type" => "banner",
          "url" => $data["banner"],
          "thumbnail_url" => $data["banner"],
        ]);
      }
    } catch (Exception $e) {
      DB::rollback();
      abort(500, $e->getMessage());
    }

    DB::commit();

    $refreshed = $article->fresh()->load(["roles", "media"]);

    return [
      "article" => $refreshed,
    ];
  }
}
