<?php

namespace App\Events;

use Illuminate\Database\Eloquent\Model;

class UUIDModelCreating
{
  public $model;

  /**
   * Create a new event instance.
   *
   * @param  \Illuminate\Database\Eloquent\Model  $model
   * @return void
   */
  public function __construct(Model $model)
  {
    $this->model = $model;
  }
}

