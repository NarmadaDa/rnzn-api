<?php

namespace App\Http\Controllers\Admin\Channel;

use Illuminate\Validation\ValidationException;
use App\Http\Requests\Channel\UpdateChannelRequest;
// use App\Http\Controllers\Article\BaseArticleController;
use App\Http\Controllers\Controller;
use App\Models\Channel;
use DB;
use Validator;

class UpdateChannel extends Controller
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

    $channel  = Channel::where("uuid",$uuid)->first();

    if (!$channel) {
      abort(404, "Channel does not exist.");
    } 

    DB::beginTransaction();

    try {
      $channel->name          = $data["name"];
      $channel->initial_post  = $data["initial_post"];
      $channel->post_pin      = $data["post_pin"];
      $channel->image         = $data["image"]; 
      $channel->save();
 

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
