<?php

namespace App\Http\Controllers\Admin\Channel;

use App\Http\Controllers\Channel\BaseChannelController;
use App\Http\Requests\Channel\CreateChannelRequest;
use App\Models\Channel;
use Exception;
use Illuminate\Support\Facades\DB;

class CreateChannel extends BaseChannelController
{
  /**
   * Handle the incoming request.
   *
   * @param  \App\Http\Requests\Article\CreateChannelRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function __invoke(CreateChannelRequest $request)
  {
    $data = $request->validated();  

    DB::beginTransaction();

    try {

      $channel = Channel::create([
        "name"            => $data["name"], 
        "initial_post"    => $data["initial_post"],
        "post_pin"        => $data["post_pin"], 
        "channel_active"  => 1,
        "image"           => $data["image"],     
      ]); 

  } catch (Exception $e) {
      DB::rollback();
      abort(500, $e->getMessage());
  }

  DB::commit();

  return [
    "message" => "Channel successfully created.",
  ];
    
  }
}
