<?php

namespace App\Repositories\Eloquent;

use App\Models\Article;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\ArticleRepositoryInterface;

/**
 * Class ArticleRepository
 * @package App\Repositories\Eloquent
 */
class ArticleRepository extends BaseRepository implements
  ArticleRepositoryInterface
{
  /**
   * ArticleRepository constructor.
   *
   * @param App\Models\Article $model
   */
  public function __construct(Article $model)
  {
    parent::__construct($model);
  }

  /**
   * @param string $uuid
   * @return void
   */
  public function deleteByUUID(string $uuid)
  {
    return $this->model->where("uuid", $uuid)->delete();
  }

  /**
   * @param string $slug
   * @return App\Models\Article
   */
  public function findBySlug(string $slug): ?Article
  {
    return $this->model
      ->with(["roles", "media"])
      ->where("slug", $slug)
      ->first();
  }

  /**
   * @param string $uuid
   * @return App\Models\Article
   */
  public function findByUUID(string $uuid): ?Article
  {
    return $this->model
      ->with(["roles", "media"])
      ->where("uuid", $uuid)
      ->first();
  }
}
