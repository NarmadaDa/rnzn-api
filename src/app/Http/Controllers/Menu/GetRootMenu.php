<?php

namespace App\Http\Controllers\Menu;

use App\Http\Controllers\Menu\BaseMenuController;
use Illuminate\Http\Request;

class GetRootMenu extends BaseMenuController
{
  /**
   * Handle the incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function __invoke(Request $request)
  {
    $slug = "guest-root";
    if ($user = $request->user()) {
      if ($user->isPersonnel() || $user->isAdmin()) {
        $slug = "personnel-root";
      }
    }

    $menu = $this->menuRepository->findBySlug($slug, true);
    if (!$menu) {
      abort(404, "Menu does not exist.");
    }

    $menu = $this->getMenuItems($menu, "");

    return [
      "menu" => $menu,
    ];
  }

  private function getMenuItems($menu, $crumbs)
  {
    foreach ($menu->menuItems as $mi) {
      $breadcrumbs = $crumbs;
      if ($mi->slug !== "personnel-root") {
        $breadcrumbs = $crumbs ? $crumbs . "  /  " . $mi->title : $mi->title;
      }

      $mi->breadcrumbs = $crumbs;

      if ($mi->item_type === "menu") {
        $mi->item->load(["menuItems.item", "menuItems.media"]);
        $mi->item = $this->getMenuItems($mi->item, $breadcrumbs);
      } elseif ($mi->item_type === "article") {
        $mi->item->load(["media"]);
      }
    }

    return $menu;
  }
}
