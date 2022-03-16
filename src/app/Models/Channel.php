<?php

namespace App\Models;
 
use App\Models\UUIDModel; 

class Channel extends UUIDModel
{
  // use SoftDeletes;

  protected $morphClass = "channel";

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ["name", "post_pin", "initial_post", "channel_active", "image", "created_at", "updated_at"];
  
  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [];


}
