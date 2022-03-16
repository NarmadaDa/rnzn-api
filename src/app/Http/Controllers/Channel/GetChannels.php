<?php

namespace App\Http\Controllers\Channel;

use App\Http\Controllers\Channel\BaseChannelController; 

class GetChannels extends BaseChannelController
{
  /**
   * Handle the incoming request.
   *
   * @return \Illuminate\Http\Response
   */
  public function __invoke()
  {    
    $channel = $this->channelRepository->all_channel();
    if (!$channel) {
      abort(404, "Channel does not exist.");
    }
 
    return [
      "channels" => $channel
    ];
  }
}
 
