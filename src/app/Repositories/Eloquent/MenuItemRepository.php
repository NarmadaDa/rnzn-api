<?php

namespace App\Repositories\Eloquent;

use App\Models\MenuItem;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\MenuItemRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * Class MenuItemRepository
 * @package App\Repositories\Eloquent
 */
class MenuItemRepository extends BaseRepository implements MenuItemRepositoryInterface
{
  /**
   * MenuItemRepository constructor.
   * 
   * @param App\Models\MenuItem $model
   */
  public function __construct(MenuItem $model)
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
   * @return App\Models\MenuItem
   */
  public function findBySlug(string $slug): ?MenuItem
  {
    return $this->model->where('slug', $slug)->with('item')->first();
  }

  /**
   * @param string $uuid
   * @return App\Models\MenuItem
   */
  public function findByUUID(string $uuid): ?MenuItem
  {
    return $this->model->where('uuid', $uuid)->first();
  }

  /**
   * @param $id
   * @return array
   */
  public function getItemsForArticleItemById($id): iterable
  {
    return $this->model->where('item_id', $id)
      ->where('item_type', 'article')
      ->with('item')
      ->get();
  }

  /**
   * @param $id
   * @return array
   */
  public function getItemsForMenuItemById($id): iterable
  {
    return $this->model->where('item_id', $id)
      ->where('item_type', 'menu')
      ->with('item')
      ->get();
  }

  /**
   * @param string $query
   * @return array
   */
  public function search(string $query): iterable
  {
    $filtered = '%'.Str::lower($query).'%';
    return $this->model->where('title', 'like', $filtered)
      ->orWhere('slug', 'like', $filtered)
      ->get();
  }
}
