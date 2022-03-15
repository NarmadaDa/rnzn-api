<?php

use Illuminate\Support\Facades\Route;

Route::namespace("Conditions")
  ->prefix("conditions")
  ->middleware(["auth:api"])
  ->group(function () {
    Route::as("all")->get("", GetAllConditions::class);
  });
