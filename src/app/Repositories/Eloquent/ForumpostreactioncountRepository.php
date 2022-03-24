<?php

namespace App\Repositories\Eloquent;

use App\Models\ForumPostReactionCount; 
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\ForumpostreactioncountRepositoryInterface;

/**
 * Class ArticleRepository
 * @package App\Repositories\Eloquent
 */
class ForumpostreactioncountRepository extends BaseRepository implements
ForumpostreactioncountRepositoryInterface
{
  /**
   * ArticleRepository constructor.
   *
   * @param App\Models\ForumPostReactionCount $model
   */
  public function __construct(ForumPostReactionCount $model)
  {
    parent::__construct($model);
  }

   /**
   * @param string $uuid
   * @return App\Models\ForumPostReactionCount
   */
  public function findByUUID(string $uuid): ?ForumPostReactionCount
  {
    return $this->model  
      ->where("uuid", $uuid)
      ->first();
  }  

  /**
  * @param string $uuid
  * @return App\Models\ForumPostReactionCount
  */
 public function findReactionByUser(string $uuid, int $user_id): ?ForumPostReactionCount
 {
   return $this->model  
     ->where("uuid", $uuid)
     ->where("user_id", $user_id)
     ->first();
 }  

 /**
 * @param string $uuid
 * @return App\Models\ForumPostReactionCount
 */
public function findByPostID($id): ?ForumPostReactionCount
{
  return $this->model   
    ->where("post_id", $id)
    ->first();
} 

}
