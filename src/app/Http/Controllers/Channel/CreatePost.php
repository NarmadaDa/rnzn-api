<?php

namespace App\Http\Controllers\Channel;

use App\Http\Controllers\Channel\BaseChannelController; 
use App\Http\Requests\Channel\CreatePostRequest; 
use App\Models\ForumPost;
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
 
      $post_data1 = Arr::add($data, 'user_id' , $user_id );  
      $post_data = Arr::add($post_data1, 'uuid' , $user_uuid );   

      // insert data to "forum_normal_posts"
      $this->formpostRepository->create($post_data);  
      // $form_post = $this->formpostRepository->create($post_data);  

      // // insert data to "channel_posts"
      // $post_id = ForumPost::find($form_post->id);
      // $post_id->channel()->attach($colorId, ['size_id' => $sizeId]);


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
 
