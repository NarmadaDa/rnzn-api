<?php

use Illuminate\Support\Facades\Route;

Route::namespace("Channel")
  ->prefix("channels")
  ->middleware(["auth:api"])
  ->group(function () {
    Route::as("all")->get('/', GetChannels::class); 
    Route::as("pin")->post("{id}/posts", PinChannelPost::class);
  });
