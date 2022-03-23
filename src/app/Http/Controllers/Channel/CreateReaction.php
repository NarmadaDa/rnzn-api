<?php

namespace App\Http\Controllers\Channel;

use App\Http\Controllers\Channel\BaseChannelController; 
use App\Http\Requests\Channel\CreateReactionRequest;   
use App\Models\ForumPostReactionCount;
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
    $user_id = $request->user()->id;  
    $user_uuid = $request->user()->uuid;  
   
    $post = $this->formpostRepository->findByUUID($request["uuid"]); 
    if (!$post) {
      abort(404, "Post does not exist.");
    }

    DB::beginTransaction();

    try {    
  
      $post_reaction = Arr::add($data, 'post_uuid' , $data['uuid']); 
      $post_reaction2 = Arr::add($post_reaction, 'user_id' , $user_id);     
 
      $reaction = $this->forumpostreactionRepository->create($post_reaction2);  

      $reactions_count = ForumPostReactionCount::select("like_count", "haha_count", "wow_count", "sad_count", "angry_count")->where("post_id", $reaction->id)->get(); 

      if($reactions_count){
 
         foreach ($reactions_count as $r) {
 
           $like_count   = ($r->like_count ? $r->like_count +=1 : $r->like_count);
           $haha_count   = ($r->haha_count ? $r->haha_count +=1 : $r->haha_count);
           $wow_count    = ($r->wow_count ? $r->wow_count +=1 : $r->wow_count);
           $sad_count    = ($r->sad_count ? $r->sad_count +=1 : $r->sad_count);
           $angry_count  = ($r->angry_count ? $r->angry_count +=1 : $r->angry_count);
 
           $count = ForumPostReactionCount::find($r->id);
           $count->like_count   = $like_count;
           $count->haha_count   = $haha_count;
           $count->wow_count    = $wow_count;
           $count->sad_count    = $sad_count;
           $count->angry_count  = $angry_count;
           $count->save();
 
         }

      } else {   
      
          $like_count = 0; 
          $haha_count = 0;
          $wow_count = 0; 
          $sad_count = 0; 
          $angry_count = 0;

          $emoji  = $data['emoji'];
          if($emoji == 1){ // like
            $like_count = 1;
          } else if($emoji == 2){ // haha 
            $haha_count = 1;
          }  else if($emoji == 3){ // wow
            $wow_count = 1;
          }  else if($emoji == 4){ // sad
            $sad_count = 1;
          }  else if($emoji == 5){ // angry
            $angry_count = 1;
          }

          $like_count = ForumPostReactionCount::create([
            "post_id"     => $reaction->id,
            "like_count"  => $like_count,
            "haha_count"  => $haha_count,
            "wow_count"   => $wow_count,
            "sad_count"   => $sad_count,
            "angry_count" => $angry_count,
          ]); 
     
      }
       
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
 
