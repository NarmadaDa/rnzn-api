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

  public function posts()
  { 
    return $this->hasMany(ForumPost::class, "channel_id")->orderBy('pin_post', 'desc'); 
  }   
  
} 
 