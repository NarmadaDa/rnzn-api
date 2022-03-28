<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Model; 

class CommentReaction extends Model
{

  protected $table = "comment_reactions";

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ["post_id", "uuid", "emoji"]; 
  
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
