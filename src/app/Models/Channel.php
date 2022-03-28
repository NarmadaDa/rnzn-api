<?php

namespace App\Models;
 
use App\Models\UUIDModel;
use App\Models\Profile;
use App\Models\ForumPost; 
use DB;
use map;

class Channel extends UUIDModel
{
  // use SoftDeletes;

  protected $morphClass = "channel";

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ["name", "post", "channel_active", "image", "user_id", "created_at", "updated_at"];
  
  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [];

 /**
   * Relationships
   */

  public function profile()
  {
    return $this->belongsTo(Profile::class, "user_id");
  }
  
  public function posts(int $id)
  {   
    $posts = DB::table('channels AS c')
      ->join('forum_posts AS fp', 'c.id', '=', 'fp.channel_id')  
      ->join('profiles AS p', 'p.user_id', '=', 'fp.user_id')
      ->join('users AS u', 'fp.user_id', '=', 'u.id')   

      ->select('fp.id', 'fp.channel_id AS channelId', 'fp.uuid AS postUuid','fp.post', 'fp.pin_post AS pinPost', "fp.created_at AS createdAt", "fp.updated_at AS updatedAt",
      'p.first_name AS firstName', 'p.middle_name AS middleName', 'p.last_name AS lastName', 'p.image', 'u.uuid AS userUUID',  
      
      DB::raw("(SELECT GROUP_CONCAT(uuid) FROM forum_post_reactions WHERE likes = 1)  as like_users"),
      DB::raw("(SELECT GROUP_CONCAT(uuid) FROM forum_post_reactions WHERE haha = 1)  as haha_users"),
      DB::raw("(SELECT GROUP_CONCAT(uuid) FROM forum_post_reactions WHERE wow = 1)  as wow_users"),
      DB::raw("(SELECT GROUP_CONCAT(uuid) FROM forum_post_reactions WHERE sad = 1)  as sad_users"),
      DB::raw("(SELECT GROUP_CONCAT(uuid) FROM forum_post_reactions WHERE angry = 1)  as angry_users")
      )  

      ->where('c.id', '=', $id)
      ->where('c.channel_active', '=', 1)
      ->orderBy('pinPost', 'desc')
      ->orderBy('createdAt', 'asc')
      ->get();   
 
      return $posts;
 
  }     
  
} 


//     DB::raw("(SELECT JSON_ARRAY(GROUP_CONCAT(uuid)) FROM forum_post_reactions WHERE likes = 1)  as like_users"),