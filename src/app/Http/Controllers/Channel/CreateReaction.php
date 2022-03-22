<?php

namespace App\Http\Controllers\Channel;

use App\Http\Controllers\Channel\BaseChannelController; 
use App\Http\Requests\Channel\CreateReactionReques; 
use App\Models\ForumPost;  
use App\Models\Comment;  
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

  public function __invoke(CreateReactionReques $request)
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

      Reaction::create([
        "uuid" => $post->id, 
        "post_type_id" => $post_type_id, 
        "content" => $request["content"],
      ]);  
      


    } catch (Exception $e) {
        DB::rollback();
        abort(500, $e->getMessage());
    }

    DB::commit();

    return [
      "message" => "Reaction to a post/reply successfully created.",
    ];
  }


}
 
