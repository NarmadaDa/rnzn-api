<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Model; 

class Emoji extends Model
{ 

  protected $table = "emojis";
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ["emoji"];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [];

  /**
   * Relationships
   */
 
}
