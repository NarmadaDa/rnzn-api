<?php

namespace App\Models;
 
use App\Models\UUIDModel; 
use App\Models\Channel;
use App\Models\ForumPost;

class Comment extends UUIDModel
{
  // use SoftDeletes;

  protected $morphClass = "comments";

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ["post_id", "post_type_id", "content", "uuid", "created_at", "updated_at"];
  
  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = ["emoji_id", "emoji_count"];

 /**
   * Relationships
   */ 

  public function forumpost()
  {
    return $this->belongsTo(ForumPost::class);
  }
 
}
