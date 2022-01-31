<?php

namespace App\Repositories\Interfaces;

use App\Models\Menu;

/**
 * Interface MenuRepositoryInterface
 * @package App\Repositories\Interfaces
 */
interface MenuRepositoryInterface
{
  /**
   * @param string $uuid
   * @return void
   */
  public function deleteByUUID(string $uuid);

  /**
   * @param string $slug
   * @return App\Models\Menu
   */
  public function findBySlug(string $slug): ?Menu;

  /**
   * @param string $uuid
   * @return App\Models\Menu
   */
  public function findByUUID(string $uuid): ?Menu;
}
