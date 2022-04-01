<?php

namespace App\Models;

use App\Models\User;
use App\Models\Channel;
use App\Models\ForumPost;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profile extends Model
{
  use SoftDeletes;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ["user_id", "first_name", "middle_name", "last_name"];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
    "id",
    "user_id",
    "created_at",
    "updated_at",
    "deleted_at",
  ];

  /**
   * Relationships
   */

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function channels()
  {
    return $this->belongsTo(Channel::class, "user_id");
  }  
   
}
