<?php

namespace App\Models;

use App\Models\SocialAccountToken;
use App\Models\SocialPost;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SocialAuthSession extends Model
{
  use SoftDeletes;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    "social_account_id",
    "code",
    "user_access_token",
    "long_lived_user_token",
    "page_access_token",
    "long_lived_page_token",
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
    "id",
    "social_account_id",
    "created_at",
    "updated_at",
    "deleted_at",
  ];

  /**
   * Relationships
   */

  public function account()
  {
    return $this->belongsTo(SocialAccount::class);
  }
}
