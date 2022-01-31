<?php

namespace App\Models;

use App\Models\MenuItem;
use App\Models\User;
use App\Models\UUIDModel;

class QuickLink extends UUIDModel
{
  protected $keyType = "string";
  protected $primaryKey = "uuid";
  public $incrementing = false;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ["menu_item_id", "user_id", "sort_order"];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
    "menu_item_id",
    "user_id",
    "created_at",
    "updated_at",
    "deleted_at",
  ];

  /**
   * Relationships
   */

  public function menuItem()
  {
    return $this->belongsTo(MenuItem::class);
  }

  public function user()
  {
    return $this->belongsTo(User::class);
  }
}
