<?php

namespace App\Repositories\Interfaces;

use App\Models\User;

/**
 * Interface UserRepositoryInterface
 * @package App\Repositories\Interfaces
 */
interface UserRepositoryInterface
{
  /**
   * @param string $uuid
   * @return void
   */
  public function deleteByUUID(string $uuid);

  /**
   * @param string $uuid
   * @return App\Models\User
   */
  public function findByUUID(string $uuid): ?User;
}
