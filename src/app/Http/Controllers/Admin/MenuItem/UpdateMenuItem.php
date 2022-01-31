<?php

namespace App\Http\Controllers\Admin\MenuItem;

use App\Http\Controllers\MenuItem\BaseMenuItemController;
use App\Http\Requests\MenuItem\UpdateMenuItemRequest;
use App\Models\MenuItem;
use Illuminate\Validation\ValidationException;
use Validator;

class UpdateMenuItem extends BaseMenuItemController
{
  /**
   * Handle the incoming request.
   *
   * @param  \App\Http\Requests\MenuItem\UpdateMenuItemRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function __invoke(UpdateMenuItemRequest $request)
  {
    $data = $request->validated();

    $menuItem = $this->menuItemRepository->findByUUID($data["uuid"]);
    if (!$menuItem || $menuItem->menu->uuid != $data["menu_uuid"]) {
      abort(404, "Menu Item does not exist.");
    }

    $slugMenuItem = $this->menuItemRepository->findBySlug($data["slug"]);
    if ($slugMenuItem && $menuItem->id !== $slugMenuItem->id) {
      $validator = Validator::make([], []);
      $validator->errors()->add("slug", "Slug already exists.");
      throw new ValidationException($validator);
    }

    $item = null;

    // only query item details if a new item is specified
    if ($data["item_uuid"] != $menuItem->item->uuid) {
      if ($data["item_type"] == "article") {
        $item = $this->articleRepository->findByUUID($data["item_uuid"]);
      } elseif ($data["item_type"] == "menu") {
        $item = $this->menuRepository->findByUUID($data["item_uuid"]);
      }
    }

    if (!$item) {
      abort(400, "Invalid item.");
    }

    if ($item->uuid == $menuItem->menu->uuid) {
      abort(400, "Cannot add parent Menu as a Menu Item.");
    }

    $menuItem->title = $data["title"];
    $menuItem->slug = $data["slug"];
    $menuItem->item_id = $item->id;
    $menuItem->item_type = $data["item_type"];
    $menuItem->sort_order = $data["sort_order"];
    $menuItem->save();

    $menuItem->fresh();
    $menuItem->load("item");

    return [
      "menu_item" => $menuItem,
    ];
  }
}
