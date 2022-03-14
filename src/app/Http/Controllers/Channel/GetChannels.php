<?php

namespace App\Http\Controllers\Channel;

// use App\Http\Controllers\News\BasePostController;
use App\Http\Controllers\Controller;
use App\Models\Channel;

class GetChannels extends Controller
{
  /**
   * Handle the incoming request.
   *
   * @return \Illuminate\Http\Response
   */
  public function __invoke()
  {    
    $channels = Channel::get();

    return [
      "channels" => $channels 
    ];
  }
}
 
