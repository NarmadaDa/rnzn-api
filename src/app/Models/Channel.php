<?php

namespace App\Models;

// use App\Models\ArticleFeedback;
// use App\Models\ArticleRole;
// use App\Models\Media;
// use App\Models\MenuItem;
use App\Models\UUIDModel;
use App\Models\Profile;
use App\Models\ForumPost;
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
    return $this->hasMany(ForumPost::class, "channel_id")
    ->with('profile')
    ->where('inappropriate','=', false);
  }    

}
