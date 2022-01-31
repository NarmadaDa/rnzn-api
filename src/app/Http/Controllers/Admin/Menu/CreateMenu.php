<?php

namespace App\Http\Controllers\Admin\Menu;

use App\Http\Controllers\Menu\BaseMenuController;
use App\Http\Requests\Menu\CreateMenuRequest;
use App\Models\Menu;

class CreateMenu extends BaseMenuController
{
  /**
   * Handle the incoming request.
   *
   * @param  \App\Http\Requests\Menu\CreateMenuRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function __invoke(CreateMenuRequest $request)
  {
    $data = $request->validated();

    $menu = $this->menuRepository->create([
      "name" => $data["name"],
      "slug" => $data["slug"],
    ]);

    return [
      "menu" => $menu,
    ];
  }
}
