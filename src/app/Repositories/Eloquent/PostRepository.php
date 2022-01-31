<?php

namespace App\Repositories\Eloquent;

use App\Models\Post;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\PostRepositoryInterface;
use Illuminate\Support\Collection;

/**
 * Class PostRepository
 * @package App\Repositories\Eloquent
 */
class PostRepository extends BaseRepository implements PostRepositoryInterface
{
  /**
   * PostRepository constructor.
   * 
   * @param App\Models\Post $model
   */
  public function __construct(Post $model)
  {
    parent::__construct($model);
  }

  /**
   * @param string $uuid
   * @return void
   */
  public function deleteByUUID(string $uuid)
  {
    return $this->model->where('uuid', $uuid)->delete();
  }

  /**
   * @param string $uuid
   * @return App\Models\Post
   */
  public function findByUUID(string $uuid): ?Post
  {
    return $this->model->where('uuid', $uuid)
      ->with('type')
      ->first();
  }

  /**
   * @return Illuminate\Support\Collection
   */
  public function all(): Collection
  {
    return $this->model->with('type')
      ->orderBy('created_at', 'DESC')
      ->get();
  }
}
