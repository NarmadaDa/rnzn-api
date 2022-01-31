<?php

namespace App\Http\Controllers\Admin\MenuItem;

use App\Http\Controllers\MenuItem\BaseMenuItemController;
use App\Http\Requests\MenuItem\CreateMenuItemRequest;

class CreateMenuItem extends BaseMenuItemController
{
  /**
   * Handle the incoming request.
   *
   * @param  \App\Http\Requests\Menu\CreateMenuItemRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function __invoke(CreateMenuItemRequest $request)
  {
    $data = $request->validated();

    $menu = $this->menuRepository->findByUUID($data["menu_uuid"]);
    if (!$menu) {
      abort(404, "Menu does not exist.");
    }

    $item = null;
    if ($data["item_type"] == "article") {
      $item = $this->articleRepository->findByUUID($data["item_uuid"]);
    } elseif ($data["item_type"] == "menu") {
      $item = $this->menuRepository->findByUUID($data["item_uuid"]);
    }

    if (!$item) {
      abort(400, "Invalid item.");
    }

    if ($item->uuid == $menu->uuid) {
      abort(400, "Can not add parent Menu as a Menu Item.");
    }

    $menuItem = $this->menuItemRepository->create([
      "title" => $data["title"],
      "slug" => $data["slug"],
      "sort_order" => $data["sort_order"],
      "menu_id" => $menu->id,
      "item_id" => $item->id,
      "item_type" => $data["item_type"],
    ]);

    $menuItem->fresh();
    $menuItem->load("item");

    return [
      "menu_item" => $menuItem,
    ];
  }
}
