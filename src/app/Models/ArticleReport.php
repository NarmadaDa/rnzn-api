<?php

namespace App\Models;

use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class ArticleReport extends Model
{
  protected $table = "article_reports";

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ["article_id", "user_id", "message"];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
    "id",
    "created_at",
    "deleted_at",
    "article_id",
    "user_id",
  ];

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
