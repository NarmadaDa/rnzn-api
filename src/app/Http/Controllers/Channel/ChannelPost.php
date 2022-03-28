<?php

namespace App\Http\Controllers\Channel;

use App\Http\Controllers\Channel\BaseChannelController; 
use App\Http\Requests\Channel\GetChannelByIDRequest;  
use App\Http\Controllers\PaginatedController;
use App\Models\ForumPostReaction;
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




    // return $channel_post;


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


     $like = ForumPostReaction::select(DB::raw('group_concat(uuid) as emoji'))->where('post_id', '=',  $id)->where('likes', '=',  1)->first();
     $haha = ForumPostReaction::select(DB::raw('group_concat(uuid) as emoji'))->where('post_id', '=',  $id)->where('haha', '=',  1)->first();
     $wow = ForumPostReaction::select(DB::raw('group_concat(uuid) as emoji'))->where('post_id', '=',  $id)->where('wow', '=',  1)->first();
     $sad = ForumPostReaction::select(DB::raw('group_concat(uuid) as emoji'))->where('post_id', '=',  $id)->where('sad', '=',  1)->first();
     $angry = ForumPostReaction::select(DB::raw('group_concat(uuid) as emoji'))->where('post_id', '=',  $id)->where('angry', '=',  1)->first();
       

     if($like->emoji == null && $haha->emoji == null &&  $wow->emoji == null  &&  $sad->emoji == null  &&  $angry->emoji == null){ 
      
      $reactions = null;  

     } else {

      if($like->emoji != null){
        $like  = explode(',', $like->emoji); 
      } else {
        $like = null;
      }

      if($haha->emoji != null){
        $haha  = explode(',', $haha->emoji); 
      } else {
        $haha = null;
      }

      if($wow->emoji != null){
        $wow   = explode(',', $wow->emoji); 
      } else {
        $wow = null;
      }

      if($sad->emoji != null){
        $sad   = explode(',', $sad->emoji);
      } else {
        $sad = null;
      }

      if($angry->emoji != null){
        $angry = explode(',', $angry->emoji); 
      }  else {
        $angry = null;
      }

      $reactions  = array(
        "like" =>  $like,
        "haha" =>  $haha,
        "wow" =>  $wow,
        "sad" =>  $sad,
        "angry" =>  $angry
       );

     } 



 
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
 
