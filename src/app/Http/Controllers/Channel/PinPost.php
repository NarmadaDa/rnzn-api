<?php

namespace App\Http\Controllers\Channel;

use App\Http\Controllers\Channel\BaseChannelController; 
use App\Http\Requests\Channel\PinPostRequest; 
use App\Models\ForumPost;
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
  
  public function __invoke(PinPostRequest $request)
  { 
    
    $data = $request->validated(); 
    $user_id = $request->user()->id;  
    
    $post = $this->PinPostRepository->findByUUID($data["uuid"]);
    if (!$post) {
      abort(404, "Post does not exist.");
    }
    
    $post_by_user = $this->PinPostRepository->findByUserID($data["uuid"], $user_id);
    if (!$post_by_user) {
      abort(404, "Post does not exist valid user.");
    }
    
    $pinned_posts = $this->PinPostRepository->pinned_posts();
    
    DB::beginTransaction();
    
    try {   
      
      // Pin a post
      if ($data["type"] == "pin") {
        
        //Make other pinned posts in same channel to false and pin only one post per channel
        //Iterate through pinned posts and find if there are same channel IDs
        for($x = 0; $x < count($pinned_posts) - 1; $x++){
          if($pinned_posts[$x] -> channel_id == $post -> channel_id){
            $pinned_posts[$x] -> pin_post = 0;
            $pinned_posts[$x] -> save();
            
          }              
          
        }
        //Pin current post given by uuid
        $post->pin_post = 1; 
        $post->save();
     
        //return["pinned_posts" => ($pinned_posts)];
        $message  = "Current post pinned successfully.";
        
      }else {
        
        abort(404, "Type should be 'pin'");
        
      }
      
    } catch (Exception $e) {
      DB::rollback();
      abort(500, $e->getMessage());
    }
    
    DB::commit();
    
    return [
      "message" => $message,
    ];
  }
  
  
}

