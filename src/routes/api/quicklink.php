<?php

use Illuminate\Support\Facades\Route;

Route::namespace('QuickLink')->prefix('quicklinks')
  ->middleware(['auth:api'])->group(function() {

  Route::as('all')->get('/', GetQuickLinks::class);
  Route::as('add')->post('/', AddQuickLink::class);
  Route::as('remove')->delete('{uuid}', RemoveQuickLink::class);

  Route::as('search')->get('search', SearchQuickLinkOptions::class);
});
