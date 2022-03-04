<?php

namespace App\Models;

use App\Models\Permission;
use App\Models\UUIDModel;

class Role extends UUIDModel
{
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
  protected $hidden = ["id", "created_at", "updated_at", "deleted_at", "pivot"];

  /**
   * Relationships
   */

  public function articles()
  {
    return $this->belongsToMany(
      Role::class,
      "article_roles",
      "role_id",
      "article_id"
    );
  }

  public function permissions()
  {
    return $this->belongsToMany(
      Permission::class,
      "role_permissions",
      "role_id",
      "permission_id"
    );
  }

  public function users()
  {
    return $this->belongsToMany(
      Role::class,
      "user_roles",
      "role_id",
      "user_id"
    );
  }

  /**
   * Custom functions
   */

  public static function adminRole()
  {
    return static::where("slug", "admin")->first();
  }

  public static function guestRole()
  {
    return static::where("slug", "guest")->first();
  }

  public static function personnelRole()
  {
    return static::where("slug", "personnel")->first();
  }

  public static function superAdminRole()
  {
    return static::where("slug", "super")->first();
  }
}
