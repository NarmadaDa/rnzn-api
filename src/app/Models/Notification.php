<?php

namespace App\Models;

use App\Models\User;
use App\Models\UserNotification;
use App\Models\UUIDModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends UUIDModel
{
  use SoftDeletes;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ["item_id", "item_type"];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
    "id",
    "created_at",
    "updated_at",
    "deleted_at",
    "item_id",
  ];

  /**
   * Relationships
   */

  public function item()
  {
    return $this->morphTo();
  }

  public function userNotifications()
  {
    return $this->hasMany(
      UserNotification::class,
      "notification_id",
      "notification_id"
    );
  }

  public function users()
  {
    return $this->belongsToMany(
      User::class,
      "user_notifications",
      "notification_id",
      "user_id"
    );
  }
}
