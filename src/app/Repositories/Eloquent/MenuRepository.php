<?php

namespace App\Repositories\Eloquent;

use App\Models\Menu;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\MenuRepositoryInterface;

/**
 * Class MenuRepository
 * @package App\Repositories\Eloquent
 */
class MenuRepository extends BaseRepository implements MenuRepositoryInterface
{
  /**
   * MenuRepository constructor.
   * 
   * @param App\Models\Menu $model
   */
  public function __construct(Menu $model)
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
   * @param string $slug
   * @return App\Models\Menu
   */
  public function findBySlug(string $slug, $children = false): ?Menu
  {
    $query = $this->model->where('slug', $slug);
    if ($children)
    {
      $query->with(['menuItems.item', 'menuItems.media']);
    }
    return $query->first();
  }

  /**
   * @param string $uuid
   * @return App\Models\Menu
   */
  public function findByUUID(string $uuid): ?Menu
  {
    return $this->model->where('uuid', $uuid)->first();
  }
}
