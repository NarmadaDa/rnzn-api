<?php

use Illuminate\Support\Facades\Route;

Route::namespace("User")
  ->prefix("users")
  ->group(function () {
    // authenticated endpoints
    Route::middleware(["auth:api"])->group(function () {
      Route::as("feedback")->post("feedback", PostUserFeedback::class);

      // user endpoints
      Route::prefix("me")->group(function () {
        Route::as("profile")->get("/", GetUserProfile::class);
        Route::as("update")->post("/", UpdateUserProfile::class);
        // Route::as('delete')->delete('me', DeleteUser::class);
      });
    });

    Route::prefix("password")->group(function () {
      Route::as("forgot")->post("forgot", ForgotPassword::class);
      Route::as("reset")->post("reset", ChangePassword::class);
    });

    Route::as("create")->post("/", CreateUser::class);
  });
