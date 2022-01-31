<?php

namespace App\Http\Controllers\Admin\Menu;

use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Controllers\Menu\BaseMenuController;

class GetMenus extends BaseMenuController
{
  /**
   * Handle the incoming request.
   *
   * @param  Request  $request
   * @return \Illuminate\Http\Response
   */
  public function __invoke()
  {
    $main = Menu::with(["media"])->find(1);
    $banner = $main->media->where("type", "=", "banner")->first();
    $menuItems = MenuItem::with(["media", "menu", "menu.media"])->get();
    $childTree = $this->buildMenuTree($menuItems, $main->id, $main->uuid);
    return [
      "menu" => [
        "uuid" => $main->uuid,
        "title" => $main->name,
        "slug" => $main->slug,
        "item_type" => "menu",
        "banner" => $banner == null ? null : $banner->url,
        "parent_uuid" => null,
        "children" => $childTree,
      ],
      "depth" => $this->array_depth($childTree),
    ];
  }

  private function formatMenuItem(MenuItem $mi)
  {
    $banner = $mi->media->where("type", "=", "banner")->first();
    return [
      "uuid" => $mi->uuid,
      "title" => $mi->title,
      "slug" => $mi->slug,
      "item_type" => $mi->item_type,
      "banner" => $banner == null ? null : $banner->url,
      "parent_uuid" => $parentUUID,
    ];
  }

  /**
   * Build a tree from a flat list of App\Models\MenuItem
   * @param Illuminate\Database\Eloquent\Collection $menuItems
   * @param integer $parentId
   */
  private function buildMenuTree(
    Collection $menuItems,
    $parentId = 0,
    $parentUUID = null
  ) {
    $branch = [];
    foreach ($menuItems as $mi) {
      $banner = $mi->media->where("type", "=", "banner")->first();
      // $icon = $mi->menu_id == 1 ? $mi->menu->media->where('type', '=', 'icon')->first() : null;
      $menu = [
        "uuid" => $mi->uuid,
        "title" => $mi->title,
        "slug" => $mi->slug,
        "item_type" => $mi->item_type,
        "banner" => $banner == null ? null : $banner->url,
        "parent_uuid" => $parentUUID,
      ];

      if ($mi->menu_id == $parentId) {
        if ($mi->item_type == "menu") {
          $children = $this->buildMenuTree($menuItems, $mi->item_id, $mi->uuid);
          if ($children) {
            $menu["children"] = $children;
          }
        }
        $branch[] = $menu;
      }
    }
    return $branch;
  }

  private function array_depth(array $array)
  {
    $max_depth = 1;
    foreach ($array as $value) {
      if (is_array($value)) {
        $depth = $this->array_depth($value) + 1;

        if ($depth > $max_depth) {
          $max_depth = $depth;
        }
      }
    }
    return $max_depth;
  }
}
