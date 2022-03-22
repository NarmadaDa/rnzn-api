<?php

namespace App\Repositories\Eloquent;

use App\Models\ForumPost;
use App\Models\Channel;
use App\Models\Comment;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\ForumpostRepositoryInterface;

/**
 * Class ArticleRepository
 * @package App\Repositories\Eloquent
 */
class CommentRepository extends BaseRepository implements
ForumpostRepositoryInterface
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
   * @return App\Models\Comment
   */
  public function findByUUID(string $uuid): ?Comment
  {
    return $this->model  
      ->where("uuid", $uuid)
      ->first();
  }

}
