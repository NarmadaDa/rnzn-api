<?php

namespace App\Http\Controllers\Notification;

use App\Http\Controllers\Controller;
use App\Http\Requests\Notification\MarkNotificationAsViewedRequest;
use App\Models\Notification;
use App\Models\UserNotification;
use Carbon\Carbon;

class MarkNotificationAsViewed extends Controller
{
  /**
   * Handle the incoming request.
   *
   * @param  \App\Http\Requests\Notification\MarkNotificationAsViewedRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function __invoke(MarkNotificationAsViewedRequest $request)
  {
    $data = $request->validated();
    $user = $request->user();

    $notification = Notification::with(['item'])
      ->where('uuid', $data['uuid'])
      ->first();

    if (!$notification)
    {
      // notification doesn't exist
      abort(404);
    }

    $viewed = UserNotification::firstOrCreate([
      'notification_id' => $notification->id,
      'user_id' => $user->id,
    ]);

    if (!$viewed->viewed_at) {
      // set the notification as viewed, if not already
      $viewed->viewed_at = Carbon::now();
      $viewed->save();
    }

    $notification->viewed_at = $viewed->viewed_at;
    
    return [
      'notification' => $notification,
    ];
  }
}
