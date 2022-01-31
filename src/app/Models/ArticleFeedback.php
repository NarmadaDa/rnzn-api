<?php

namespace App\Models;

use App\Models\Article;
use App\Models\User;
use App\Traits\HasCompositePrimaryKey;
use Illuminate\Database\Eloquent\Model;

class ArticleFeedback extends Model
{
  use HasCompositePrimaryKey;

  protected $table = "article_feedback";
  public $incrementing = false;
  protected $primaryKey = ["article_id", "user_id"];

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ["article_id", "user_id", "rating"];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = ["deleted_at", "article_id", "user_id"];

  /**
   * Relationships
   */

  public function article()
  {
    return $this->belongsTo(Article::class, "article_id");
  }

  public function user()
  {
    return $this->belongsTo(User::class, "user_id");
  }
}
