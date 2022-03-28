<?php

namespace App\Http\Controllers\Channel;

use App\Http\Controllers\Channel\BaseChannelController; 
use App\Http\Requests\Channel\CreateReactionRequest;   
use App\Models\ForumPostReaction; 
use Illuminate\Support\Arr;
use Exception;
use Illuminate\Support\Facades\DB;

class CreateReaction extends BaseChannelController
{
  /**
   * Handle the incoming request.
   *
   * @return \Illuminate\Http\Response
   */ 

  public function __invoke(CreateReactionRequest $request)
  {        
   
    $data = $request->validated(); 
    $user_uuid = $request->user()->uuid;   
   
    $post = $this->formpostRepository->findByUUID($request["uuid"]); 
    if (!$post) {
      abort(404, "Post does not exist.");
    }
 
    DB::beginTransaction();

    try {    

      $emoji   = $data['emoji']; 
      $like   = ($emoji == "like" ? 1 : '');
      $haha   = ($emoji == "haha" ? 1 : '');
      $wow    = ($emoji == "wow" ? 1 : '');
      $sad    = ($emoji == "sad" ? 1 : '');
      $angry  = ($emoji == "angry" ? 1 : ''); 

    
 
      $reaction = ForumPostReaction::create([
        'post_id' => $post->id, 
        'uuid' => $user_uuid,
        'likes' => $like,
        'haha' => $haha,
        'wow' => $wow,
        'sad' => $sad,
        'angry' => $angry
      ]);  
 

     //  $reactionByUser = $this->forumpostreactionRepository->findReactionByUser($request["uuid"], $user_id);
     
      
  
    } catch (Exception $e) {
        DB::rollback();
        abort(500, $e->getMessage());
    }

    DB::commit();

    return [
      "message" => "Reaction to a post/comment/reply successfully created.",
    ];
  }


}
 
