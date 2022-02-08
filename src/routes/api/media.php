<?php

use App\Http\Controllers\Media\MediaController;
use Illuminate\Support\Facades\Route;

Route::namespace('Media')
->prefix('media') 
// ->middleware(["auth:XssSanitizer"])
->group(function() {
  Route::post('/', [MediaController::class, 'upload']);
  Route::get('/list', [MediaController::class, 'list']);
});

