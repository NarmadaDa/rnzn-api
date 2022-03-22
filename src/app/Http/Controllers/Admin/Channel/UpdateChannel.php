<?php

namespace App\Http\Controllers\Admin\Channel;

use Illuminate\Validation\ValidationException;
use App\Http\Requests\Channel\UpdateChannelRequest;
use App\Http\Controllers\Channel\BaseChannelController;  
use DB;
use Validator;

class UpdateChannel extends BaseChannelController
{
  /**
   * Handle the incoming request.
   *
   * @param  \App\Http\Requests\Article\UpdateChannelRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function __invoke(UpdateChannelRequest $request)
  {
    $data = $request->validated();
    $uuid = $request->route("uuid");

    $channel = $this->channelRepository->findByUUID($data["uuid"]); 
    if (!$channel) {
      abort(404, "Channel does not exist.");
    } 

    DB::beginTransaction();

    try {
      $channel->name            = $data["name"]; 
      $channel->channel_active  = $data["channel_active"]; 
      $channel->image           = $data["image"]; 
      $channel->save(); 
 
      //  post update ...

    } catch (\Exception $e) {
      DB::rollback();
      abort(500, $e->getMessage());
    }

    DB::commit();
 
    return [
      "channel" => $channel,
    ];
  }
}
