<?php

namespace App\Models;

use App\Models\Media;
use App\Models\MenuItem;
use App\Models\MenuRole;
use App\Models\Role;
use App\Models\UUIDModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends UUIDModel
{
  use SoftDeletes;

  protected $morphClass = "menu";

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ["name", "slug"];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = ["id", "created_at", "updated_at", "deleted_at"];

  /**
   * Relationships
   */

  public function media()
  {
    return $this->morphMany(Media::class, "mediable");
  }

  public function menuItem()
  {
    return $this->morphMany(MenuItem::class, "item");
  }

  public function menuItems()
  {
    return $this->hasMany(MenuItem::class, "menu_id", "id");
  }

  public function menuRole()
  {
    return $this->belongsTo(MenuRole::class);
  }

  public function roles()
  {
    return $this->belongsToMany(
      Role::class,
      "menu_roles",
      "menu_id",
      "role_id"
    );
  }
}
