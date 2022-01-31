<?php

namespace App\Models;

use App\Models\MenuItem;
use App\Models\Role;
use App\Traits\HasCompositePrimaryKey;
use Illuminate\Database\Eloquent\Model;

class MenuItemRole extends Model
{
  use HasCompositePrimaryKey;

  public $incrementing = false;
  protected $primaryKey = ["menu_item_id", "user_id"];

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ["menu_item_id", "role_id"];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = ["created_at", "deleted_at"];

  /**
   * Relationships
   */

  public function menuItem()
  {
    return $this->belongsTo(MenuItem::class);
  }

  public function role()
  {
    return $this->belongsTo(Role::class);
  }
}
