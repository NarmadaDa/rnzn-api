<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaginatedController extends Controller
{
  /**
   * Handle the incoming request.
   *
   * @param  string  $label
   * @param  \Illuminate\Pagination\Paginator  $paginator
   * @return \Illuminate\Http\Response
   */
  public function paginate($label = 'results', $paginator = null)
  {
    return [
      $label => array_values($paginator->items()),
      'metadata' => [
        'current_page'  => $paginator->currentPage(),
        'from'          => $paginator->firstItem(),
        'last_page'     => $paginator->lastPage(),
        'per_page'      => $paginator->perPage(),
        'to'            => $paginator->lastItem(),
        'total'         => $paginator->total(),
        'links'         => [
          'url_first_page'    => $paginator->url(1),
          'url_last_page'     => $paginator->url($paginator->lastPage()),
          'url_next_page'     => $paginator->nextPageUrl(),
          'url_previous_page' => $paginator->previousPageUrl(),
        ],
      ],
    ];
  }
}
