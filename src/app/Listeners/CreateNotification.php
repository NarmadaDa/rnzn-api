<?php

namespace App\Listeners;

use App\Events\NewsPostCreated;
use App\Models\Notification;
use App\Models\User;
use App\Models\UserNotification;

class CreateNotification
{
  /**
   * Handle the event.
   *
   * @param  \App\Events\NewsPostCreated  $event
   * @return void
   */
  public function handle(NewsPostCreated $event)
  {
    $post = $event->post;
  
    $notification = Notification::create([
      "item_type" => "news_post",
      "item_id" => $post->id,
    ]);

    // TODO: notifications only for specific roles
    $users = User::all();
    foreach ($users as $user) {
      UserNotification::create([
        'notification_id' => $notification->id,
        'user_id' => $user->id,
      ]);
    }
  }
}
