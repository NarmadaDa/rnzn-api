<?php

use Illuminate\Support\Facades\Route;

Route::namespace("Social")
  ->prefix("social")
  ->group(function () {
    Route::as("accounts")->get("accounts", GetSocialAccounts::class);
    Route::as("posts")->get("posts", GetSocialPosts::class);

    Route::as("facebook.")
      ->prefix("facebook")
      ->group(function () {
        // webhooks
        Route::as("webhooks.")
          ->prefix("webhooks")
          ->group(function () {
            Route::as("login")->get("login", FBAuthCallback::class);
          });
      });
  });
