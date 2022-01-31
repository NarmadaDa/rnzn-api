<?php

namespace App\Repositories\Interfaces;

use App\Models\Role;

/**
 * Interface RoleRepositoryInterface
 * @package App\Repositories\Interfaces
 */
interface RoleRepositoryInterface
{
  /**
   * @param string $slug
   * @return App\Models\Role
   */
  public function findBySlug(string $slug): ?Role;

  /**
   * @param string $uuid
   * @return App\Models\Role
   */
  public function findByUUID(string $uuid): ?Role;
}
