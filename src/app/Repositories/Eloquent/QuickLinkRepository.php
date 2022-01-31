<?php

namespace App\Repositories\Eloquent;

use App\Models\QuickLink;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\QuickLinkRepositoryInterface;

/**
 * Class QuickLinkRepository
 * @package App\Repositories\Eloquent
 */
class QuickLinkRepository extends BaseRepository implements QuickLinkRepositoryInterface
{
  /**
   * QuickLinkRepository constructor.
   * 
   * @param App\Models\QuickLink $model
   */
  public function __construct(QuickLink $model)
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
   * @return App\Models\QuickLink
   */
  public function findByUUID(string $uuid): ?QuickLink
  {
    return $this->model->where('uuid', $uuid)->first();
  }

  /**
   * @param $userID
   * @param $menuItemID
   * @return App\Models\QuickLink
   */
  public function findForUser($userID, $menuItemID): ?QuickLink
  {
    return $this->model->where('user_id', $userID)
      ->where('menu_item_id', $menuItemID)
      ->first();
  }

  /**
   * @param $userID
   * @return array
   */
  public function allForUser($userID): iterable
  {
    return $this->model->where('user_id', $userID)
      ->orderBy('sort_order')
      ->get();
  }
}
