<?php

namespace App\Models;

use App\Models\SocialAuthSession;
use App\Models\SocialPost;
use App\Models\UUIDModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class SocialAccount extends UUIDModel
{
  use SoftDeletes;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ["type", "social_id", "name"];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = ["social_id", "created_at", "updated_at", "deleted_at"];

  /**
   * Relationships
   */

  public function posts()
  {
    return $this->hasMany(SocialPost::class);
  }

  public function sessions()
  {
    return $this->hasMany(SocialAuthSession::class);
  }

  public static function authorisedAccounts()
  {
    return static::whereNotNull("social_id");
  }
}
