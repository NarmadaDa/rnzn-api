<?php

namespace App\Http\Controllers\Admin\Menu;

use App\Http\Controllers\Menu\BaseMenuController;
use App\Http\Requests\Menu\DeleteMenuRequest;
use App\Models\Menu;

class DeleteMenu extends BaseMenuController
{
  /**
   * Handle the incoming request.
   *
   * @param  \App\Http\Requests\Menu\DeleteMenuRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function __invoke(DeleteMenuRequest $request)
  {
    $data = $request->validated();

    $menu = $this->menuRepository->findByUUID($data["uuid"]);
    if (!$menu) {
      abort(404, "Menu does not exist.");
    }

    $menu->delete();

    return [
      "message" => "Menu successfully deleted.",
    ];
  }
}
