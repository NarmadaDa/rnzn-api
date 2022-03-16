<?php

namespace App\Http\Controllers\Admin\Channel;
 
use App\Http\Controllers\Channel\BaseChannelController; 

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
    $channels = $this->channelRepository->all_channel(); 
    
    if (!$channels) {
      abort(404, "Channels does not exist.");
    }

    return [
      "channels" => $channels 
    ];
  }
}
