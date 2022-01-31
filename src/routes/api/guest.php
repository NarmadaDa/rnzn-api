<?php

use Illuminate\Support\Facades\Route;

Route::namespace('Guest')->prefix('guests')->group(function() {
  Route::as('create')->post('/', CreateGuest::class);
});

