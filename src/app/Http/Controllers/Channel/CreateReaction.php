<?php

namespace App\Http\Controllers\Channel;

use App\Http\Controllers\Channel\BaseChannelController; 
use App\Http\Requests\Channel\CreateReactionRequest;    
use App\Models\ForumPostReaction;  
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
    $user_id = $request->user()->id;   
    $user_uuid = $request->user()->uuid;   
   
    $post = $this->formpostRepository->findByUUID($request["uuid"]); 
    if (!$post) {
      abort(404, "Post does not exist.");
    }
 
    DB::beginTransaction();

    try {    
 
      $emoji  = strtolower($data['emoji']); 
      $like   = ($emoji == "like" ? 1 : '');
      $haha   = ($emoji == "haha" ? 1 : '');
      $wow    = ($emoji == "wow" ? 1 : '');
      $sad    = ($emoji == "sad" ? 1 : '');
      $angry  = ($emoji == "angry" ? 1 : ''); 

        // $reactionByUser = $this->forumpostreactionRepository->findReactionByUser($post->id, $user_id);

      // return $reactionByUser;

      $reactionByUser = ForumPostReaction::where("post_id", $post->id)
      ->where("user_id", $user_id)
      ->first();

   

      if(!$reactionByUser){

        $reaction = ForumPostReaction::create([
          'post_id' => $post->id, 
          'uuid' => $user_uuid,
          'user_id' => $user_id,
          'likes' => $like,
          'haha' => $haha,
          'wow' => $wow,
          'sad' => $sad,
          'angry' => $angry
        ]); 

        $message = "Reaction to a post successfully created.";

      } else {
        
        ForumPostReaction::where("post_id", $post->id)
        ->where("user_id", $user_id)
        ->update(['likes' => $like, 'haha' => $haha, 'wow' => $wow, 'sad' => $sad, 'angry' => $angry]);

        $message = "Reaction to a post successfully updated.";

      } 
  
    } catch (Exception $e) {
        DB::rollback();
        abort(500, $e->getMessage());
    }

    DB::commit();

    return [
      "message" => $message
    ];
  }


}
 
