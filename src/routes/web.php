<?php

use Illuminate\Support\Facades\Route;

// public endpoints
Route::namespace("Web")->group(function () {
  Route::as("web.")->group(function () {
    Route::as("aasa")->get("apple-app-site-association", GetAASA::class);
    Route::as("password.")->prefix("password")->group(function () {
      Route::as("forgot.")->prefix("forgot")->group(function () {
        Route::as("show")->get("", ShowForgotPassword::class);
        Route::as("post")->post("", PostForgotPassword::class);
      });
      Route::as("reset.")->prefix("reset")->group(function () {
        Route::as("show")->get("", ShowChangePassword::class);
        Route::as("post")->post("", PostChangePassword::class);
      });
    });
  });
  Route::as("verification.")
    ->prefix("email")
    ->group(function () {
      Route::as("verify")->get("verify/{id}", VerifyUserEmail::class);
    });
});
