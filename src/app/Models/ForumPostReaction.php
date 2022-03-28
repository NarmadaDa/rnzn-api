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
  protected $fillable = ["post_id", "uuid", "likes", "haha", "wow", "sad", "angry"]; 
  
  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = ["id", "created_at", "updated_at"];

 /**
   * Relationships
  */ 

  
  public function forumPostreaction()
  {  
    return $this->hasOne(ForumPost::class, "uuid");
  } 
}
