<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model; 

class StudentMark extends Model
{
  public $timestamps = false;
  protected $table = "student_marks";
      /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ["id", "student_id", "final_mark"];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
//   protected $hidden = ["created_at", "updated_at"];
}
