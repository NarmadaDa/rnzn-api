<?php

namespace App\Http\Controllers\Admin\Channel;
 
use App\Http\Controllers\Channel\BaseChannelController;
use App\Models\Channel; 

class GetChannels extends BaseChannelController
{
  /**
   * Handle the incoming request.
   *
   * @param  Illuminate\Http\Request  $request
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
