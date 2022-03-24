<?php

namespace App\Http\Controllers\Channel;

use App\Http\Controllers\Channel\BaseChannelController; 
use App\Http\Requests\Channel\CreateReactionRequest;   
use App\Models\ForumPostReaction;
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
   
    $post = $this->formpostRepository->findByUUID($request["uuid"]); 
    if (!$post) {
      abort(404, "Post does not exist.");
    }
 
    DB::beginTransaction();

    try {    

       $reactionByUser = $this->forumpostreactionRepository->findReactionByUser($request["uuid"], $user_id);
     
       if(!$reactionByUser){
        
        // 'forum_post_reactions' table
        $post_reaction = Arr::add($data, 'user_id' , $user_id);  
        $post_reaction2 = Arr::add($post_reaction, 'post_id' , $post->id);  
        $reaction = $this->forumpostreactionRepository->create($post_reaction2);  

        // 'forum_post_reaction_counts' table
        $like_count = 0; 
        $haha_count = 0;
        $wow_count = 0; 
        $sad_count = 0; 
        $angry_count = 0;

        $emoji  = $data['emoji'];
        if($emoji == "like"){ // like
          $like_count = 1;
        } else if($emoji == "haha"){ // haha 
          $haha_count = 1;
        }  else if($emoji == "wow"){ // wow
          $wow_count = 1;
        }  else if($emoji == "sad"){ // sad
          $sad_count = 1;
        }  else if($emoji == "angry"){ // angry
          $angry_count = 1;
        }

        $reaction_count = [
          "post_id"     => $post->id,
          "like_count"  => $like_count,
          "haha_count"  => $haha_count,
          "wow_count"   => $wow_count,
          "sad_count"   => $sad_count,
          "angry_count" => $angry_count,
        ];

        $this->forumpostreactioncountRepository->create($reaction_count); 
         
      } else {

        // 'forum_post_reactions' table
        $post_uuid = $reactionByUser->uuid;
        $reaction = $this->forumpostreactionRepository->findByUUID($post_uuid);

        // to do - update reaction by user

        $reaction->emoji  = $data["emoji"];  
        $reaction->save(); 
  
        // 'forum_post_reaction_counts' table
        $react_count = $this->forumpostreactioncountRepository->findByPostID($reaction->id);  
 
        if($react_count){ 

          $like = 0; 
          $haha = 0;
          $wow = 0; 
          $sad = 0; 
          $angry = 0;

          $like_count  = $react_count->like_count;
          $haha_count  = $react_count->haha_count;
          $wow_count   = $react_count->wow_count;
          $sad_count   = $react_count->sad_count;
          $angry_count = $react_count->angry_count;

          $emoji  = $data['emoji']; 
          $like   = ($emoji == "like" ? $like_count +=1 : $like_count);
          $haha   = ($emoji == "haha" ? $haha_count +=1 : $haha_count);
          $wow    = ($emoji == "wow" ? $wow_count +=1 : $wow_count);
          $sad    = ($emoji == "sad" ? $sad_count +=1 : $sad_count);
          $angry  = ($emoji == "angry" ? $angry_count +=1 : $angry_count); 

          $react_count->like_count   = $like;
          $react_count->haha_count   = $haha;
          $react_count->wow_count    = $wow;
          $react_count->sad_count    = $sad;
          $react_count->angry_count  = $angry;
          $react_count->save();

        }
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
 
