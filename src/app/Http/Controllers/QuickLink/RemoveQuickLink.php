<?php

namespace App\Http\Controllers\QuickLink;

use App\Http\Controllers\QuickLink\BaseQuickLinkController;
use App\Http\Requests\QuickLink\RemoveQuickLinkRequest;
use App\Models\QuickLink;

class RemoveQuickLink extends BaseQuickLinkController
{
  /**
   * Handle the incoming request.
   *
   * @param  \App\Http\Requests\QuickLink\RemoveQuickLinkRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function __invoke(RemoveQuickLinkRequest $request)
  {
    $data = $request->validated();
    $user = $request->user();

    $quickLink = $this->quickLinkRepository->findByUUID($data['uuid']);
    if (!$quickLink)
    {
      abort(404, 'Quick Link does not exist.');
    }
    
    $quickLink->delete();
    
    return [
      'message' => 'Quick Link successfully deleted.',
    ];
  }
}
