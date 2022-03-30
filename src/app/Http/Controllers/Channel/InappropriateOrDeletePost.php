<?php

namespace App\Http\Controllers\Channel;

use App\Http\Controllers\Channel\BaseChannelController; 
use App\Http\Requests\Channel\InappropriateRequest; 
use App\Models\ForumPost;
use Illuminate\Support\Arr;
use Exception;
use Illuminate\Support\Facades\DB;

class InappropriateOrDeletePost extends BaseChannelController
{
  /**
   * Handle the incoming request.
   *
   * @return \Illuminate\Http\Response
   */ 

  public function __invoke(InappropriateRequest $request)
  { 
 
    $data = $request->validated(); 
    $user_id = $request->user()->id;  

    $post = $this->inappropriateRepository->findByUUID($data["uuid"]);
    if (!$post) {
      abort(404, "Post does not exist.");
    }
 
    DB::beginTransaction();

    try {   

      // Inappropriate a post
      if ($data["type"] == "inappropriate") {

        $post->inappropriate = true; 
        $post->save();

        $message  = "Inappropriate post successfully created.";

      } else if ($data["type"] == "delete") {
 
        if($user->userRole->role_id == 1 || $user->userRole->role_id == 2 ){

          //Admin so delete post
          $this->inappropriateRepository->deleteByUUID($data["uuid"]);
          $message  = "Post successfully deleted.";

        } else {

          $post_by_user = $this->inappropriateRepository->findByUserID($data["uuid"], $user_id);
          if (!$post_by_user) {
            abort(404, "Post does not exist valid user.");
          }

          $this->inappropriateRepository->deleteByUUID($data["uuid"]);
          $message  = "Post successfully deleted.";
          
        }

      } else {

        abort(404, "Type should be 'inappropriate' or 'delete'");

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
 
