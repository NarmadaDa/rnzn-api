<?php

namespace App\Http\Controllers\Channel;

use App\Http\Controllers\Channel\BaseChannelController; 
use App\Http\Requests\Channel\GetChannelByIDRequest; 

class PinChannelPost extends BaseChannelController
{
  /**
   * Handle the incoming request.
   *
   * @return \Illuminate\Http\Response
   */ 

  public function __invoke(GetChannelByIDRequest $request)
  {
    $data = $request->validated(); 

    $channel = $this->channelRepository->findByID($data["id"]);
    if (!$channel) {
      abort(404, "Channel does not exist.");
    }

    $channel_pin_post = $this->channelRepository->findByPinPost($data["id"]);
    if (!$channel_pin_post) {
      abort(404, "Pined post does not exist.");
    }

    return [
      "channel" => $channel_pin_post,
    ];
  }


}
 
