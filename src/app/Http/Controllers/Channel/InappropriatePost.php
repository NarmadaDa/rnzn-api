<?php

namespace App\Http\Controllers\Channel;

use App\Http\Controllers\Channel\BaseChannelController; 
use App\Http\Requests\Channel\InappropriateRequest; 
use App\Models\ForumPost;
use Illuminate\Support\Arr;
use Exception;
use Illuminate\Support\Facades\DB;

class InappropriatePost extends BaseChannelController
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

    $post_by_user = $this->inappropriateRepository->findByUserID($data["uuid"], $user_id);
    if (!$post_by_user) {
      abort(404, "Post does not exist valid user.");
    }
 
    DB::beginTransaction();

    try {   

      // Inappropriate a post
      if ($data["type"] == "inappropriate") {

        $post->inappropriate = true; 
        $post->save();

        $message  = "Inappropriate post successfully created.";
      } else if ($data["type"] == "delete") {

        // Delete a post - only if the particular user has created it 
        $this->inappropriateRepository->deleteByUUID($data["uuid"]);
        $message  = "Post successfully deleted.";

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
 
