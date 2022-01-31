<?php

namespace App\Events;

use App\Models\Post;
use Illuminate\Foundation\Events\Dispatchable;

class NewsPostCreated
{
  use Dispatchable;
   
  public $post;

  /**
   * Create a new event instance.
   *
   * @param  \App\Models\Post  $post
   * @return void
   */
  public function __construct(Post $post)
  {
    $this->post = $post;

    \Log::info("Dispatching NewsPostCreated event");
  }
}
