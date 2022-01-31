<?php

namespace App\Http\Controllers\QuickLink;

use App\Http\Controllers\QuickLink\BaseQuickLinkController;
use App\Http\Requests\QuickLink\AddQuickLinkRequest;
use App\Models\QuickLink;

class AddQuickLink extends BaseQuickLinkController
{
  /**
   * Handle the incoming request.
   *
   * @param  \App\Http\Requests\QuickLink\AddQuickLinkRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function __invoke(AddQuickLinkRequest $request)
  {
    $data = $request->validated();
    $user = $request->user();

    $menuItem = $this->menuItemRepository->findByUUID($data['menu_item_uuid']);
    if (!$menuItem)
    {
      abort(404, 'Menu Item does not exist.');
    }

    $sameQuickLink = $this->quickLinkRepository->findForUser(
      $user->id,
      $menuItem->id,
    );
    if ($sameQuickLink)
    {
      abort(400, 'Quick Link already exists.');
    }

    $quickLink = $this->quickLinkRepository->create([
      'user_id'       => $user->id,
      'menu_item_id'  => $menuItem->id,
      'sort_order'    => $data['sort_order'],
    ]);

    $quickLink->load('menuItem');
    
    return [
      'quick_link' => $quickLink,
    ];
  }
}
