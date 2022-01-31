<?php

namespace App\Models;

use App\Models\Article;
use App\Models\Media;
use App\Models\Menu;
use App\Models\UUIDModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class MenuItem extends UUIDModel
{
  use SoftDeletes;

  protected $morphClass = "menu_item";

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    "title",
    "slug",
    "menu_id",
    "item_id",
    "item_type",
    "sort_order",
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
    "menu_id",
    "item_id",
    "menu",
  ];

  /**
   * Relationships
   */

  public function item()
  {
    return $this->morphTo();
  }

  public function media()
  {
    return $this->morphMany(Media::class, "mediable");
  }

  public function menu()
  {
    return $this->belongsTo(Menu::class);
  }
}
