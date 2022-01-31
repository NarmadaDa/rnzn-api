<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\UserRepositoryInterface;

/**
 * Class UserRepository
 * @package App\Repositories\Eloquent
 */
class UserRepository extends BaseRepository implements UserRepositoryInterface
{
  /**
   * UserRepository constructor.
   * 
   * @param App\Models\User $model
   */
  public function __construct(User $model)
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
   * @return App\Models\User
   */
  public function findByUUID(string $uuid): ?User
  {
    return $this->model->where('uuid', $uuid)->first();
  }
}
