<?php

use Illuminate\Support\Facades\Route;

// public endpoints
Route::as("passport.")
  ->middleware(["device.verify"])
  ->namespace("Auth")
  ->group(function () {
    Route::as("token")->post("token", AuthenticateUser::class);

    // authorisation required
    Route::group(["middleware" => ["auth:api"]], function () {
      Route::as("tokens.destroy")->delete(
        "tokens/{token_id}",
        LogoutUser::class
      );
    });
  });

// admin endpoints
Route::as("admin.")
  ->namespace("Admin")
  ->prefix("admin")
  ->group(function () {
    // /admin/oauth/token
    Route::as("auth.")
      ->namespace("Auth")
      ->group(function () {
        Route::as("token")->post("token", AuthenticateAdmin::class);
      });
  });
