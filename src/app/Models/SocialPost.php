<?php

namespace App\Models;

use App\Models\Media;
use App\Models\SocialAccount;
use App\Models\UUIDModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class SocialPost extends UUIDModel
{
  use SoftDeletes;

  protected $morphClass = "social_post";

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    "title",
    "content",
    "social_account_id",
    "post_id",
    "post_url",
    "type",
    "posted_at",
  ];

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
    "social_account_id",
  ];

  /**
   * Custom functionality
   */

  public function getJSON()
  {
    $json = [
      "uuid" => $this->uuid,
      "title" => $this->title,
      "content" => $this->content,
      "created_at" => $this->created_at,
    ];
    return json_encode($json);
  }

  public function unixtimestamp()
  {
    $ts = Carbon::parse($this->posted_at);
    return $ts->timestamp;
  }

  /**
   * Relationships
   */

  public function media()
  {
    return $this->morphMany(Media::class, "mediable");
  }

  public function account()
  {
    return $this->belongsTo(SocialAccount::class, "social_account_id");
  }

  /**
   * Attributes
   */

  public function getPostedAtAttribute($value)
  {
    return Carbon::parse($value, "UTC")->toIso8601String();
  }
}
