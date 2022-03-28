<?php

namespace App\Http\Controllers\Channel;

use App\Http\Controllers\Channel\BaseChannelController; 
use App\Http\Requests\Channel\GetChannelByIDRequest;  
use App\Http\Controllers\PaginatedController;
use App\Models\User;
use Illuminate\Support\Facades\DB;

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

    $id = $channel_post->id;  
    $name = $channel_post->name;   
    $image = $channel_post->image;  
    $uuid = $channel_post->channelUuid; 
    $created_at = $channel_post->createdAt; 
    $updated_at = $channel_post->updatedAt; 

    $channel = [ 
      'id' => $id,
      'name' => $name,
      'image' => $image,
      'channelUuid' => $uuid,
      'createdAt' => $created_at,
      'updatedAt' => $updated_at, 
    ]; 

    

    $like = null;
    $haha = null;
    $wow = null;
    $sad = null;
    $angry = null;
    $size = count($channel_post->posts);

    for ($i = 0; $i < $size; $i++)
    {

     $id = $channel_post->posts[$i]->id; 
     $channelId = $channel_post->posts[$i]->channelId; 
     $postUuid = $channel_post->posts[$i]->postUuid; 
     $post = $channel_post->posts[$i]->post; 
     $pinPost = $channel_post->posts[$i]->pinPost; 
     $createdAt = $channel_post->posts[$i]->createdAt; 
     $updatedAt = $channel_post->posts[$i]->updatedAt; 
     $firstName = $channel_post->posts[$i]->firstName; 
     $middleName = $channel_post->posts[$i]->middleName; 
     $lastName = $channel_post->posts[$i]->lastName; 
     $image = $channel_post->posts[$i]->image; 
     $userUUID = $channel_post->posts[$i]->userUUID;   

     

    $like = $channel_post->posts[$i]->like_users;
    $haha = $channel_post->posts[$i]->haha_users;
    $wow = $channel_post->posts[$i]->wow_users;
    $sad = $channel_post->posts[$i]->sad_users;
    $angry = $channel_post->posts[$i]->angry_users;

     if($like == null && $haha == null &&  $wow == null  &&  $sad == null  &&  $angry == null){
      
      $reactions = null;  

     } else {

      if($like != null){
        $like  = explode(',', $channel_post->posts[$i]->like_users); 
      }

      if($haha != null){
        $haha  = explode(',', $channel_post->posts[$i]->haha_users); 
      }

      if($wow != null){
        $wow   = explode(',', $channel_post->posts[$i]->wow_users); 
      }

      if($sad != null){
        $sad   = explode(',', $channel_post->posts[$i]->sad_users);
      }

      if($angry != null){
        $angry = explode(',', $channel_post->posts[$i]->angry_users); 
      } 

     } 


    $reactions  = array(
     "like" =>  $like,
     "haha" =>  $haha,
     "wow" =>  $wow,
     "sad" =>  $sad,
     "angry" =>  $angry
    );

     


     $posts[] = [ 
      'id' => $id,
      'channelId' => $channelId,
      'postUuid' => $postUuid,
      'post' => $post,
      'pinPost' => $pinPost,
      'createdAt' => $created_at,
      'updatedAt' => $updatedAt,
      "firstName" =>  $firstName,
      "middleName" =>  $middleName,
      "lastName" =>  $lastName,
      "image" =>  $image,
      "userUUID" =>  $userUUID, 
      "reactions" =>  $reactions
    ];
 
 
    }


    $post_data['channel'] = $channel;
    $post_data['posts'] = $posts;  
 
    return  $post_data;
  }


}
 
