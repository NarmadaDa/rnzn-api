<?php

namespace App\Models;

// use App\Models\ArticleFeedback;
// use App\Models\ArticleRole;
// use App\Models\Media;
// use App\Models\MenuItem;
use App\Models\UUIDModel;
// use App\Models\Role;
// use Illuminate\Database\Eloquent\SoftDeletes;

class Channel extends UUIDModel
{
  // use SoftDeletes;

  protected $morphClass = "channel";

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ["name", "post_pin", "initial_post", "channel_active"];
  
  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = ["created_at", "updated_at"];


}
