<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Device extends Model
{
  use SoftDeletes;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ["user_id", "uuid", "type"];

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

  /**
   * Custom functions
   */

  public function platform()
  {
    return $this->type === "ios"
      ? "apns"
      : ($this->type === "android"
        ? "gcm"
        : "");
  }
}
