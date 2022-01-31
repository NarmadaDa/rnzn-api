<?php

namespace App\Listeners;

use App\Events\UUIDModelCreating;
use Str;

class GenerateModelUUID
{
  /**
   * Handle the event.
   *
   * @param  \App\Events\UUIDModelCreating  $event
   * @return void
   */
  public function handle(UUIDModelCreating $event)
  {
    $model = $event->model;
    $model->uuid = (string)Str::uuid();
  }
}
