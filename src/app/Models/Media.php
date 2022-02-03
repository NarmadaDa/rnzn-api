<?php

namespace App\Models;

use App\Models\UUIDModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Media extends UUIDModel
{
  use SoftDeletes;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    "mediable_id",
    "mediable_type",
    "type",
    "thumbnail_url",
    "url", 
    "file_type",
    "dimensions",
    "file_size",
    "updated_at",
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
    "id",
    "created_at",
    "deleted_at",
    "mediable_id",
    "mediable_type",
  ];

  /**
   * Relationships
   */

  public function mediable()
  {
    return $this->morphTo();
  }
}
