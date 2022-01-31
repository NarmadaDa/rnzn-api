<?php

use Illuminate\Support\Facades\Route;

Route::namespace('Notification')->prefix('notifications')
  ->middleware(['auth:api'])->group(function() {

  Route::as('get')->get('/', GetNotifications::class);
  Route::as('subscribe')->post('subscribe', SubscribeToNotifications::class);
  Route::as('view')->post('view', MarkNotificationAsViewed::class);
});
