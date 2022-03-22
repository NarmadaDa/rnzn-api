<?php

namespace App\Http\Controllers\Channel;

use App\Http\Controllers\Channel\BaseChannelController; 
use App\Http\Requests\Channel\CreateCommentRequest; 
use App\Models\ForumPost;  
use App\Models\Comment;  
use Illuminate\Support\Arr;
use Exception;
use Illuminate\Support\Facades\DB;

class CreateComment extends BaseChannelController
{
  /**
   * Handle the incoming request.
   *
   * @return \Illuminate\Http\Response
   */ 

  public function __invoke(CreateCommentRequest $request)
  {   
 
    $data = $request->validated(); 
    $user_id = $request->user()->id;  
    $user_uuid = $request->user()->uuid;  
   
    $post = $this->formpostRepository->findByUUID($request["uuid"]); 
    if (!$post) {
      abort(404, "Post does not exist.");
    }

    $post_type = $request["post_type"];

    if($post_type == "comment"){
      $post_type_id = 2;
    } else if($post_type == "reply"){
      $post_type_id = 3;
    } else {

    }
 
    DB::beginTransaction();

    try {    

      Comment::create([
        "post_id" => $post->id, 
        "post_type_id" => $post_type_id, 
        "content" => $request["content"],
      ]);  
      


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
 
