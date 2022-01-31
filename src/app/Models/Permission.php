<?php

namespace App\Models;

use App\Models\Role;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ["name", "slug"];

  /**
   * Relationships
   */

  public function roles()
  {
    return $this->belongsToMany(
      Role::class,
      "role_permissions",
      "permission_id",
      "role_id"
    );
  }
}
