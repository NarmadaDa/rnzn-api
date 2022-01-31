<?php

namespace App\Models;

use App\Models\Article;
use App\Models\User;
use App\Traits\HasCompositePrimaryKey;
use Illuminate\Database\Eloquent\Model;

class UserFeedback extends Model
{
  protected $table = "user_feedback";

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    "user_id",
    "rating",
    "recommendation",
    "positives",
    "improvements",
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = ["created_at", "deleted_at", "user_id"];

  /**
   * Relationships
   */

  public function user()
  {
    return $this->belongsTo(User::class, "user_id");
  }
}
