<?php

namespace App\Repositories\Eloquent;

use App\Models\Role;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\RoleRepositoryInterface;

/**
 * Class RoleRepository
 * @package App\Repositories\Eloquent
 */
class RoleRepository extends BaseRepository implements RoleRepositoryInterface
{
  /**
   * RoleRepository constructor.
   * 
   * @param App\Models\Role $model
   */
  public function __construct(Role $model)
  {
    parent::__construct($model);
  }

  /**
   * @param string $slug
   * @return App\Models\Role
   */
  public function findBySlug(string $slug): ?Role
  {
    return $this->model->where('slug', $slug)->first();
  }

  /**
   * @param string $uuid
   * @return App\Models\Role
   */
  public function findByUUID(string $uuid): ?Role
  {
    return $this->model->where('uuid', $uuid)->first();
  }
}
