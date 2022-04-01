<?php

namespace App\Http\Controllers\Channel;

use App\Http\Controllers\Channel\BaseChannelController; 
use App\Http\Requests\Channel\GetChannelByIDRequest;  
use App\Http\Controllers\PaginatedController;
use App\Http\Resources\ChannelResource; 
use App\Models\ForumPostReaction;
use App\Models\Channel;
use App\Models\User;
use DB;

class ChannelPost extends BaseChannelController
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

    $channel_post = $this->channelRepository->findByPost($data["id"]);
    if (!$channel_post) {
      abort(404, "Pined post does not exist.");
    }  
 
    $channelByPost = ChannelResource::collection(Channel::where("id", $data["id"])
    ->where("channel_active", 1)
    ->with(["posts"])
    ->get()); 
     
    return  $channelByPost;
 
  }


}
 
