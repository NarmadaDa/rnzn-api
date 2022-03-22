<?php

namespace App\Http\Controllers\Admin\Channel;

use App\Http\Controllers\Channel\BaseChannelController;
use App\Http\Requests\Channel\CreateChannelRequest;
use App\Models\ForumPost;
use Illuminate\Support\Arr;
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
    $user_id = $request->user()->id;  

    DB::beginTransaction();
    $posts  = array();

    try {   
       
      $channel_data2 = Arr::add($data, 'channel_active' , 1 );  
      $channel_data3 = Arr::add($channel_data2, 'user_id' , $user_id );    
 
      $channel = $this->channelRepository->create($channel_data3);   

      if($channel->id){

        ForumPost::create([
          "channel_id"  => $channel->id,
          "post"        => $request['post'],
          "pin_post"    => $request['post_pin'],
          "user_id"     => $user_id
        ]);
 
      }

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
