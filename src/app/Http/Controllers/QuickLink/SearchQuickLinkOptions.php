<?php

namespace App\Http\Controllers\QuickLink;

use App\Http\Controllers\QuickLink\BaseQuickLinkController;
use App\Http\Requests\QuickLink\SearchQuickLinkOptionsRequest;
use App\Models\QuickLink;

class SearchQuickLinkOptions extends BaseQuickLinkController
{
  /**
   * Handle the incoming request.
   *
   * @param  \App\Http\Requests\QuickLink\SearchQuickLinkOptionsRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function __invoke(SearchQuickLinkOptionsRequest $request)
  {
    $data = $request->validated();

    $query = "";
    if (isset($data['query']))
    {
      $query = $data['query'];
    }

    $results = $this->menuItemRepository->search($query);
    
    return [
      'search_results' => $results,
    ];
  }
}
