<?php

namespace App\Models;

use App\Models\ArticleFeedback;
use App\Models\ArticleRole;
use App\Models\Media;
use App\Models\MenuItem;
use App\Models\UUIDModel;
use App\Models\Role;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends UUIDModel
{
  use SoftDeletes;

  protected $morphClass = "article";

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ["title", "slug", "content", "keywords", "summary", "url", "thumbnail_url"];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = ["deleted_at"];

  /**
   * Custom functionality
   */

  public function getJSON()
  {
    $json = [
      "uuid" => $this->uuid,
      "title" => $this->title,
      "content" => $this->title,
      "content" => $this->content,
      "created_at" => $this->created_at,
    ];
    return json_encode($json);
  }

  /**
   * Relationships
   */

  public function articleRole()
  {
    return $this->belongsTo(ArticleRole::class);
  }

  public function feedback()
  {
    return $this->hasMany(ArticleFeedback::class, "article_id");
  }

  public function menuItem()
  {
    return $this->morphMany(MenuItem::class, "item");
  }

  public function media()
  {
    return $this->morphMany(Media::class, "mediable");
  }

  public function roles()
  {
    return $this->belongsToMany(
      Role::class,
      "article_roles",
      "article_id",
      "role_id"
    );
  }
}
