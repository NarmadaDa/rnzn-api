<?php

namespace App\Models;

use App\Models\Notification;
use App\Models\User;
use App\Traits\HasCompositePrimaryKey;
use Illuminate\Database\Eloquent\Model;

class UserNotification extends Model
{
  use HasCompositePrimaryKey;
  /**
   * The attributes that should be cast to timestamps.
   *
   * @var array
   */
  protected $dates = ["created_at", "updated_at", "viewed_at"];

  public $incrementing = false;
  protected $primaryKey = ["notification_id", "user_id"];

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ["notification_id", "user_id", "viewed_at"];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
    "notification_id",
    "user_id",
    "created_at",
    "updated_at",
  ];

  /**
   * Relationships
   */

  public function notification()
  {
    return $this->belongsTo(Notification::class, "notification_id");
  }

  public function user()
  {
    return $this->belongsTo(User::class, "user_id");
  }
}
