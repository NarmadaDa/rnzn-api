<?php

namespace App\Http\Controllers\Channel;

use App\Http\Controllers\Channel\BaseChannelController;
use Illuminate\Http\Request;
use App\Models\Channel;

class GetChannelByUUID extends BaseChannelController
{
  /**
   * Handle the incoming request.
   *
   * @param  Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function __invoke(Request $request)
  {
    $user = $request->user();
    $uuid = $request->route("uuid"); 

    $channel = $this->channelRepository->findByUUID($uuid);
    if (!$channel) {
      abort(404, "Channel does not exist.");
    }

    return [
      "channel" => $channel,
    ];
  }
}
