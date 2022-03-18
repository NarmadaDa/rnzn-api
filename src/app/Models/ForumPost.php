<?php

namespace App\Models;

use App\Models\UUIDModel;

class ForumPost extends UUIDModel
{

  protected $table = "forum_normal_posts";

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ["post", "inappropriate", "user_id", "created_at", "updated_at"];
  
  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [];

 /**
   * Relationships
   */


}
