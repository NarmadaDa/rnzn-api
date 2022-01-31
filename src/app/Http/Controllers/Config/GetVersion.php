<?php

namespace App\Http\Controllers\Config;

use App\Http\Controllers\Controller;

class GetVersion extends Controller
{
  /**
   * Handle the incoming request.
   *
   * @return \Illuminate\Http\Response
   */
  public function __invoke()
  {
    return [
      "version" => "1.1.11",
    ];
  }
}
