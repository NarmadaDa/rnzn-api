<?php

namespace App\Http\Controllers\Channel;

use App\Http\Controllers\Channel\BaseChannelController; 
use App\Http\Requests\Channel\CreatePostRequest; 
use App\Models\ForumPost; 
use App\Models\PostType; 
use Illuminate\Support\Arr;
use Exception;
use Illuminate\Support\Facades\DB;

class PinPost extends BaseChannelController
{
  /**
   * Handle the incoming request.
   *
   * @return \Illuminate\Http\Response
   */ 

  public function __invoke(CreatePostRequest $request)
  { 

    $data = $request->validated(); 
    $user_id = $request->user()->id;  
    $user_uuid = $request->user()->uuid;  

    $channel = $this->channelRepository->findByID($data["channel_id"]);
    if (!$channel) {
      abort(404, "Channel does not exist.");
    }

    DB::beginTransaction();

    try {   
 
      // insert data to "forum_posts"
      $form_post_id = $this->formpostRepository->create([
         "post" => $data["post"], 
         "channel_id" => $data["channel_id"], 
         "user_id" => $user_id,
      ]);   

    } catch (Exception $e) {
        DB::rollback();
        abort(500, $e->getMessage());
    }

    DB::commit();

    return [
      "message"   => "Post successfully created.",
      "post_uuid" => $form_post_id->uuid
    ];
  }


}
 
