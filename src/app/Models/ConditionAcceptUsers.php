<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model; 

class ConditionAcceptUsers extends Model
{
  protected $table = "condition_accept_users";
      /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ["id", "condition_id", "accepted_by"];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = ["created_at", "updated_at"];
}
