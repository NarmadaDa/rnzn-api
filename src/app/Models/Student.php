<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model; 

class Student extends Model
{
  protected $table = "students";
      /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ["id", "name", "age"];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
//   protected $hidden = ["created_at", "updated_at"];
}
