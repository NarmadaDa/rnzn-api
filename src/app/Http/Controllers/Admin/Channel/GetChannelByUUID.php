<?php

namespace App\Http\Controllers\Admin\Channel;

// use App\Http\Controllers\Article\BaseArticleController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Channel;

class GetChannelByUUID extends Controller
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

    $channel  = Channel::where("uuid",$uuid)->first();

    if (!$channel) {
      abort(404, "Channel does not exist.");
    }

    return [
      "channel" => $channel,
    ];
  }
}
