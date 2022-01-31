<?php

namespace App\Models;

use App\Models\Post;
use Illuminate\Database\Eloquent\Model;

class PostType extends Model
{
  public $timestamps = false;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ["type"];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = ["id"];

  /**
   * Relationships
   */

  public function post()
  {
    return $this->hasOne(Post::class);
  }

  public static function newsPostType()
  {
    return static::where("type", "news")->first();
  }
}
