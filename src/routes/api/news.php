<?php

use Illuminate\Support\Facades\Route;

Route::namespace("News")
  ->prefix("news")
  ->middleware(["auth:api"])
  ->group(function () {
    Route::as("all")->get("", GetAllNewsPosts::class);
    Route::as("details")->get("{uuid}", GetNewsPost::class);
  });
