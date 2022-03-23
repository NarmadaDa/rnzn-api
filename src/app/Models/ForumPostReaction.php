<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Model; 

class ForumPostReaction extends Model
{

  protected $table = "forum_post_reactions";

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ["post_uuid", "emoji", "user_id"]; 
  
  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = ["id", "post_uuid", "user_id", "created_at", "updated_at"];

 /**
   * Relationships
  */ 

  
  public function forumPostreaction()
  {  
    return $this->hasOne(ForumPost::class, "uuid");
  } 
}
