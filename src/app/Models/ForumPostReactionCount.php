<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Model; 

class ForumPostReactionCount extends Model
{

  protected $table = "forum_post_reaction_counts";

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ["post_id", "like_count", "haha_count", "wow_count", "sad_count", "angry_count"]; 
  
  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = ["id", "created_at", "updated_at"];

 /**
   * Relationships
  */ 

}
