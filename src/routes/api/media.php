<?php

use App\Http\Controllers\Media\MediaController;
use Illuminate\Support\Facades\Route;

Route::namespace('Media')->prefix('media')->group(function() {
  Route::post('/', [MediaController::class, 'upload']);
});

