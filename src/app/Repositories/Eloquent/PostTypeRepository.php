<?php

namespace App\Repositories\Eloquent;

use App\Models\PostType;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\PostTypeRepositoryInterface;

/**
 * Class PostTypeRepository
 * @package App\Repositories\Eloquent
 */
class PostTypeRepository extends BaseRepository implements PostTypeRepositoryInterface
{
  /**
   * PostTypeRepository constructor.
   * 
   * @param App\Models\PostType $model
   */
  public function __construct(PostType $model)
  {
    parent::__construct($model);
  }

  /**
   * @param string $type
   * @return App\Models\PostType
   */
  public function findByType(string $type): ?PostType
  {
    return $this->model->where('type', $type)->first();
  }
}
