<?php

use Illuminate\Support\Facades\Route;

Route::namespace("Conditions")
  ->prefix("conditions")
  ->middleware(["auth:api"])
  ->group(function () {
    Route::as("all")->get("", GetAllConditions::class);
    Route::as("update")->post("{uuid}", UpdateAcceptConditionsByUser::class);  
  });
