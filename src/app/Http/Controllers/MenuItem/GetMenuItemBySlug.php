<?php

namespace App\Http\Controllers\MenuItem;

use App\Http\Controllers\MenuItem\BaseMenuItemController;
use App\Http\Requests\MenuItem\GetMenuItemBySlugRequest;
use App\Models\MenuItem;

class GetMenuItemBySlug extends BaseMenuItemController
{
  /**
   * Handle the incoming request.
   *
   * @param  \App\Http\Requests\MenuItem\GetMenuItemBySlugRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function __invoke(GetMenuItemBySlugRequest $request)
  {
    $data = $request->validated();

    $menuItem = $this->menuItemRepository->findBySlug($data['slug']);
    if (!$menuItem)
    {
      abort(404, 'Menu Item does not exist.');
    }

    $menu = $this->menuRepository->findByUUID($data['menu_uuid']);
    if (!$menu || $menu->id !== $menuItem->menu_id)
    {
      abort(404, 'Menu Item does not exist.');
    }
    
    return [
      'menu_item' => $menuItem,
    ];
  }
}
