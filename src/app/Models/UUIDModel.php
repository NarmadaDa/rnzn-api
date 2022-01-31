<?php

namespace App\Models;

use App\Events\UUIDModelCreating;
use Illuminate\Database\Eloquent\Model;

class UUIDModel extends Model
{
  /**
   * The event map for the model.
   *
   * @var array
   */
  protected $dispatchesEvents = [
    "creating" => UUIDModelCreating::class,
  ];
}
