<?php

namespace App\Http\Controllers\Menu;

use App\Http\Controllers\Menu\BaseMenuController;
use App\Http\Requests\Menu\GetMenuBySlugRequest;

class GetMenuBySlug extends BaseMenuController
{
  /**
   * Handle the incoming request.
   *
   * @param  \App\Http\Requests\Menu\GetMenuBySlugRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function __invoke(GetMenuBySlugRequest $request)
  {
    $data = $request->validated();
    $user = $request->user();

    $menu = $this->menuRepository->findBySlug($data["slug"], true);
    if (!$menu) {
      abort(404, "Menu does not exist.");
    }

    $ids = $menu
      ->roles()
      ->pluck("id")
      ->toArray();

    $authorised = $user
      ->roles()
      ->whereIn("id", $ids)
      ->exists();

    if (!$authorised) {
      abort(401, "Unauthorised.");
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
