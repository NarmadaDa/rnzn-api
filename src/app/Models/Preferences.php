<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Preferences extends Model
{
  use SoftDeletes;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ["user_id", "google_2fa_secret"];

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

  public function getGoogle2faSecretAttribute($value)
  {
    return empty($value) ? $value : decrypt($value);
  }

  public function setGoogle2faSecretAttribute($value)
  {
    $this->attributes["google_2fa_secret"] = empty($value)
      ? $value
      : encrypt($value);
  }
}
