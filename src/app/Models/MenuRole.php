<?php

namespace App\Models;

use App\Models\Menu;
use App\Models\Role;
use App\Traits\HasCompositePrimaryKey;
use Illuminate\Database\Eloquent\Model;

class MenuRole extends Model
{
  use HasCompositePrimaryKey;

  public $incrementing = false;
  protected $primaryKey = ["menu_item_id", "user_id"];

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ["menu_id", "role_id"];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = ["created_at", "deleted_at"];

  /**
   * Relationships
   */

  public function menu()
  {
    return $this->belongsTo(Menu::class);
  }

  public function role()
  {
    return $this->belongsTo(Role::class);
  }
}
