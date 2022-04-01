<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;  
use App\Http\Resources\ForumpostostreactionResource;  
use App\Http\Resources\ProfileResource; 
use App\Models\Profile; 
use App\Models\ForumPostReaction;
use DB;

class ForumpostostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {   

        $like   = DB::table('forum_post_reactions')->select(DB::raw('GROUP_CONCAT(uuid) as likes'))->where('post_id', '=', $this->id)->where('likes', '=', 1)->first();  
        $haha   = DB::table('forum_post_reactions')->select(DB::raw('GROUP_CONCAT(uuid) as haha'))->where('post_id', '=', $this->id)->where('haha', '=', 1)->first();  
        $wow    = DB::table('forum_post_reactions')->select(DB::raw('GROUP_CONCAT(uuid) as wow'))->where('post_id', '=', $this->id)->where('wow', '=', 1)->first();  
        $sad    = DB::table('forum_post_reactions')->select(DB::raw('GROUP_CONCAT(uuid) as sad'))->where('post_id', '=', $this->id)->where('sad', '=', 1)->first();  
        $angry  = DB::table('forum_post_reactions')->select(DB::raw('GROUP_CONCAT(uuid) as angry'))->where('post_id', '=', $this->id)->where('angry', '=', 1)->first(); 

        if($like->likes == null && $haha->haha == null && $wow->wow == null && $sad->sad == null && $angry->angry == null){  
            $reactions = null;
        } else {
        
            if($like->likes == null){  
                $lk = null;   
            } else { 
                $lk = explode(',',$like->likes); 
            } 
    
            if($haha->haha == null){  
                $ha = null;   
            } else { 
                $ha = explode(',',$haha->haha); 
            } 
        
            if($wow->wow == null){  
                $ww = null;   
            } else { 
                $ww = explode(',',$wow->wow); 
            }
        
            if($sad->sad == null){  
                $sd = null;   
            } else { 
                $sd = explode(',',$sad->sad); 
            }
            
            if($angry->angry == null){  
                $agry  = null;   
            } else { 
                $agry = explode(',',$angry->angry);   
            }  

            $reactions  = [
                'like'   => $lk,
                'haha'   => $ha,
                'wow'    => $ww,
                'sad'    => $sd,
                'angry'  => $agry,   
            ];

        }

        $data   = ProfileResource::collection(Profile::where("user_id", $this->user_id)->get());

        return [ 
            'id'            => $this->id,
            'channelId'     => $this->channel_id, 
            'post'          => $this->post,
            'pinPost'       => $this->pin_post,
            'inappropriate' => $this->inappropriate, 
            'postUuid'      => $this->uuid, 
            'userId'        => $this->user_id,
            'createdAt'     => $this->created_at,
            'updatedAt'     => $this->updated_at, 
            'profile'       => $data[0],   
            'reactions'     => $reactions

        ];
    }
} 