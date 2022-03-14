<?php

namespace App\Repositories\Eloquent;

use App\Models\Channel;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\ChannelRepositoryInterface;

/**
 * Class ArticleRepository
 * @package App\Repositories\Eloquent
 */
class ChannelRepository extends BaseRepository implements
ChannelRepositoryInterface
{
  /**
   * ArticleRepository constructor.
   *
   * @param App\Models\Channel $model
   */
  public function __construct(Channel $model)
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
   * @return App\Models\Channel
   */
  public function findBySlug(int $id): ?Channel
  {
    return $this->model
      ->with(["roles", "media"])
      ->where("slug", $slug)
      ->first();
  }

  /**
   * @param string $uuid
   * @return App\Models\Channel
   */
  public function findByUUID(string $uuid): ?Channel
  {
    return $this->model
      ->with(["roles", "media"])
      ->where("uuid", $uuid)
      ->first();
  }

    /**
   * @param int $id
   * @return App\Models\Channel
   */
  public function findByID(int $id): ?Channel
  {
    return $this->model 
      ->where("id", $id) 
      ->first();
  }
  /**
 * @param int $id
 * @return App\Models\Channel
 */
public function findByPinPost(int $id): ?Channel
{
  return $this->model 
    ->where("id", $id)
    ->where("post_pin", 1)
    ->first();
}
}
