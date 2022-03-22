<?php

namespace App\Http\Controllers\Channel;

use App\Http\Controllers\Channel\BaseChannelController; 
use App\Http\Requests\Channel\CreatePostRequest; 
use App\Models\ForumPost; 
use App\Models\PostType; 
use Illuminate\Support\Arr;
use Exception;
use Illuminate\Support\Facades\DB;

class CreatePost extends BaseChannelController
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
 
      // insert data to "forum_normal_posts"
      $form_post_id = $this->formpostRepository->create([
         "post" => $data["post"], 
         "channel_id" => $data["channel_id"], 
         "user_id" => $user_id,
      ]);  
     
      // $post_data1 = Arr::add($data, 'user_id' , $user_id );  
      // $post_data2 = Arr::add($post_data1, 'uuid' , $user_uuid );   
      // $post_data = Arr::add($post_data2, 'channel_id' , $data["channel_id"] ); 

      // // // insert data to "forum_normal_posts"
      // // $this->formpostRepository->create($post_data);  
      // $form_post_id = $this->formpostRepository->create($post_data);  
      // // post_id", "post_type_id", "content", "emoji_id", "emoji_count", "uuid", "created_at", "updated_at"
      // // insert data to "comment"

      // if($data["post_type"] == 'comment'){
      //   $post_type = 2;
      // } else if($data["post_type"] == 'reply'){
      //   $post_type = 3;
      // } else {
      //   abort(404, "Post type does not match.");
      // }

      // Comment::create([
      //   "post_id" => $form_post_id,
      //   "post_type" => $post_type,
      //   "content" => $data["content"],  
      // ]);



      // $post_id = ForumPost::find($form_post->id);
      // $post_id->comments()->attach($post_id);


    } catch (Exception $e) {
        DB::rollback();
        abort(500, $e->getMessage());
    }

    DB::commit();

    return [
      "message" => "Reply to a post successfully created.",
    ];
  }


}
 
