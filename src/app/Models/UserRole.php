<?php

namespace App\Models;

use App\Models\Role;
use App\Models\User;
use App\Traits\HasCompositePrimaryKey;
use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
  use HasCompositePrimaryKey;

  public $incrementing = false;
  protected $primaryKey = ["role_id", "user_id"];

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ["role_id", "user_id"];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = ["created_at", "updated_at", "deleted_at"];

  /**
   * Relationships
   */

  public function role()
  {
    return $this->belongsTo(Role::class);
  }

  public function user()
  {
    return $this->belongsTo(User::class);
  }
}
