<?php

namespace App\Models;

use App\Models\UUIDModel;
use App\Models\Channel;
use App\Models\Comment;
use App\Models\User;
use App\Models\Profile;

class ForumPost extends UUIDModel
{

  protected $table = "forum_normal_posts";

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ["channel_id", "post", "pin_post", "inappropriate", "user_id", "created_at", "updated_at"]; 
  
  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [];

 /**
   * Relationships
  */ 

  public function channel()
  {
    return $this->belongsTo(Channel::class);
  } 
  
  public function comments()
  { 
    return $this->hasMany(Comment::class, "post_id", "id");
  }
  
  public function reactions()
  { // 
    return $this->hasMany(Comment::class, "post_id", "post_type_id");
  } 
   
  public function profile()
  {
    return $this->hasOne(Profile::class, "id", "user_id");
  }  

}
