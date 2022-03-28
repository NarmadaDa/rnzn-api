<?php

namespace App\Repositories\Eloquent;

use App\Models\ForumPostReaction; 
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\ForumpostreactionRepositoryInterface;

/**
 * Class ArticleRepository
 * @package App\Repositories\Eloquent
 */
class ForumpostreactionRepository extends BaseRepository implements
ForumpostreactionRepositoryInterface
{
  /**
   * ArticleRepository constructor.
   *
   * @param App\Models\ForumPostReaction $model
   */
  public function __construct(ForumPostReaction $model)
  {
    parent::__construct($model);
  }

   /**
   * @param string $uuid
   * @return App\Models\ForumPostReaction
   */
  public function findByUUID(string $uuid): ?ForumPostReaction
  {
    return $this->model  
      ->where("uuid", $uuid)
      ->first();
  }  

  /**
  * @param string $uuid
  * @return App\Models\ForumPostReaction
  */
 public function findReactionByUser(int $post_id, int $user_id): ?ForumPostReaction
 {
   return $this->model  
     ->where("post_id", $post_id)
     ->where("user_id", $user_id)
     ->get();
 } 

}
