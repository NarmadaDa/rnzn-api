<?php

use Illuminate\Support\Facades\Route;

Route::namespace('Device')->prefix('devices')->group(function() {
  Route::as('add')->post('/', AddDevice::class);
  Route::as('check')->post('/{uuid}/verify', CheckDevice::class);
});
