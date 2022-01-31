<?php

namespace App\Http\Controllers\QuickLink;

use App\Http\Controllers\QuickLink\BaseQuickLinkController;
use Illuminate\Http\Request;

class GetQuickLinks extends BaseQuickLinkController
{
  /**
   * Handle the incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function __invoke(Request $request)
  {    
    $user = $request->user();
    $quickLinks = $this->quickLinkRepository->allForUser($user->id);
    $quickLinks->load('menuItem');
    
    return [
      'quick_links' => $quickLinks,
    ];
  }
}
