<?php

namespace App\Models;

use App\Models\Article;
use App\Models\Role;
use App\Traits\HasCompositePrimaryKey;
use Illuminate\Database\Eloquent\Model;

class ArticleRole extends Model
{
  use HasCompositePrimaryKey;

  public $incrementing = false;
  protected $primaryKey = ["article_id", "role_id"];

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ["article_id", "role_id"];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = ["created_at", "deleted_at"];

  /**
   * Relationships
   */

  public function article()
  {
    return $this->belongsTo(Article::class);
  }

  public function role()
  {
    return $this->belongsTo(Role::class);
  }
}
