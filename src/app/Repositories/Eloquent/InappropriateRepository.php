<?php

namespace App\Repositories\Eloquent;

use App\Models\ForumPost;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\InappropriateRepositoryInterface;

/**
 * Class ArticleRepository
 * @package App\Repositories\Eloquent
 */
class InappropriateRepository extends BaseRepository implements
InappropriateRepositoryInterface
{
  /**
   * ArticleRepository constructor.
   *
   * @param App\Models\ForumPost $model
   */
  public function __construct(ForumPost $model)
  {
    parent::__construct($model);
  }

  /**
   * @param string $uuid
   * @return App\Models\ForumPost
   */
  public function findByUUID(string $uuid): ?ForumPost
  {
    return $this->model  
      ->where("uuid", $uuid)
      ->first();
  }  
  
  /**
  * @param string $uset_id
  * @return App\Models\ForumPost
  */
 public function findByUserID(string $uuid, int $user_id): ?ForumPost
 {
   return $this->model  
     ->where("uuid", $uuid)
     ->where("user_id", $user_id)
     ->first();
 }   
 
  /**
   * @param string $uuid
   * @return void
   */
  public function deleteByUUID(string $uuid)
  {
    return $this->model->where("uuid", $uuid)->delete();
  }

}
