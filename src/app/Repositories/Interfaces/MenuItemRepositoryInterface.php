<?php

namespace App\Repositories\Interfaces;

use App\Models\MenuItem;

/**
 * Interface MenuItemRepositoryInterface
 * @package App\Repositories\Interfaces
 */
interface MenuItemRepositoryInterface
{
  /**
   * @param string $uuid
   * @return void
   */
  public function deleteByUUID(string $uuid);

  /**
   * @param string $slug
   * @return App\Models\MenuItem
   */
  public function findBySlug(string $slug): ?MenuItem;

  /**
   * @param string $uuid
   * @return App\Models\MenuItem
   */
  public function findByUUID(string $uuid): ?MenuItem;

  /**
   * @param $id
   * @return array
   */
  public function getItemsForArticleItemById($id): iterable;

  /**
   * @param $id
   * @return array
   */
  public function getItemsForMenuItemById($id): iterable;

  /**
   * @param string $query
   * @return array
   */
  public function search(string $query): iterable;
}
