<?php

use App\Http\Controllers\Media\MediaController;
use Illuminate\Support\Facades\Route;

Route::namespace('Media')
->prefix('media') 
// ->middleware(["XssSanitizer"])
->group(function() {
  Route::post('/', [MediaController::class, 'upload']);
  Route::get('/list', [MediaController::class, 'list']);
  Route::get('/only_img', [MediaController::class, 'onlyimg']);
  Route::get('/no_pdf', [MediaController::class, 'nopdf']);
});

