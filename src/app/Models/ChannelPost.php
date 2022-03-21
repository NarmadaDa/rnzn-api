<?php

namespace App\Models;

use App\Models\UUIDModel;
use App\Models\Channel;
use App\Models\ForumPost;

class ChannelPost extends UUIDModel
{

  protected $table = "channel_posts";

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ["channel_id", "forum_normal_post_id", "created_at", "updated_at"];
  
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
