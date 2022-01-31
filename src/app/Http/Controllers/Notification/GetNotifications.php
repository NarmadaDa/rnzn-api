<?php

namespace App\Http\Controllers\Notification;

use App\Http\Controllers\PaginatedController;
use App\Models\Notification;
use App\Models\Post;
use Illuminate\Http\Request;
use Log;

class GetNotifications extends PaginatedController
{
  /**
   * Handle the incoming request.
   *
   * @param  Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function __invoke(Request $request)
  {
    $user = $request->user();
    // $perPage = $request->get('page_size', 20);
    $perPage = 100;

    $ids = [];
    $paginated = Notification::whereHasMorph('item',
      [Post::class]
    )
      ->with(['item'])
      ->tap(function($query) use (&$ids) {
        $ids = $query->pluck('id')->toArray();
      })
      ->orderBy('id', 'desc')
      ->paginate($perPage);

    $userNotifications = $user->userNotifications()
      ->whereIn('notification_id', $ids)
      ->get();

    foreach ($paginated->items() as $p)
    {
      $p->viewed_at = null;
      foreach ($userNotifications as $n)
      {
        if ($n->notification_id == $p->id)
        {
          $p->viewed_at = $n->viewed_at;
          break;
        }
      }
    }
    
    return $this->paginate('notifications', $paginated);
  }
}
