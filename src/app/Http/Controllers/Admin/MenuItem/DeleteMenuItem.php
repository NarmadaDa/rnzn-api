<?php

namespace App\Http\Controllers\Admin\MenuItem;

use App\Http\Controllers\MenuItem\BaseMenuItemController;
use App\Http\Requests\MenuItem\DeleteMenuItemRequest;
use App\Models\MenuItem;

class DeleteMenuItem extends BaseMenuItemController
{
  /**
   * Handle the incoming request.
   *
   * @param  \App\Http\Requests\MenuItem\DeleteMenuItemRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function __invoke(DeleteMenuItemRequest $request)
  {
    $data = $request->validated();

    $menuItem = MenuItem::where("uuid", $data["uuid"])
      ->whereHas("menu", function ($query) use ($data) {
        return $query->where("uuid", $data["menu_uuid"]);
      })
      ->first();

    if (!$menuItem) {
      abort(404, "Menu Item does not exist.");
    }

    $menuItem->delete();

    return [
      "message" => "Menu Item successfully deleted.",
    ];
  }
}
