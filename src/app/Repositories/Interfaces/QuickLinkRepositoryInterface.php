<?php

namespace App\Repositories\Interfaces;

use App\Models\QuickLink;

/**
 * Interface QuickLinkRepositoryInterface
 * @package App\Repositories\Interfaces
 */
interface QuickLinkRepositoryInterface
{
  /**
   * @param string $uuid
   * @return void
   */
  public function deleteByUUID(string $uuid);

  /**
   * @param string $uuid
   * @return App\Models\QuickLink
   */
  public function findByUUID(string $uuid): ?QuickLink;

  /**
   * @param $userID
   * @param $menuItemID
   * @return App\Models\QuickLink
   */
  public function findForUser($userID, $menuItemID): ?QuickLink;

  /**
   * @param $userID
   * @return array
   */
  public function allForUser($userID): iterable;
}
