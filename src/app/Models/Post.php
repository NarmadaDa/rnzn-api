<?php

namespace App\Models;

use App\Models\Media;
use App\Models\PostType;
use App\Models\UUIDModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends UUIDModel
{
  use SoftDeletes;

  protected $morphClass = "news_post";

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ["title", "content", "post_type_id", "summary", "url", "thumbnail_url"];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = ["id", "deleted_at", "post_type_id"];

  /**
   * Custom functionality
   */

  public function getJSON()
  {
    $json = [
      "uuid" => $this->uuid,
      "title" => $this->title,
      "content" => $this->content,
      "summary" => $this->summary,
      "created_at" => $this->created_at,
    ];
    return json_encode($json);
  }

  /**
   * Relationships
   */

  public function media()
  {
    return $this->morphMany(Media::class, "mediable");
  }

  public function type()
  {
    return $this->belongsTo(PostType::class);
  }
}
