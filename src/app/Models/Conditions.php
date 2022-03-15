<?php

namespace App\Models;
use App\Models\UUIDModel;
//use Illuminate\Database\Eloquent\Model;

class Conditions extends UUIDModel
{
  
  protected $morphClass = "conditions";

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ["title", "description"];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = ["id", "created_at", "updated_at"];



}
