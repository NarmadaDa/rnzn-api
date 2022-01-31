<?php

use Illuminate\Support\Facades\Route;

// menus
Route::namespace("Menu")
  ->prefix("menus")
  ->middleware(["auth:api"])
  ->group(function () {
    Route::as("root")->get("root", GetRootMenu::class);
    Route::as("details")->get("{slug}", GetMenuBySlug::class);
  });

// menu items
Route::as("items.")
  ->namespace("MenuItem")
  ->prefix("menus/{menu_uuid}/items")
  ->middleware(["auth:api"])
  ->group(function () {
    Route::as("details")->get("{slug}", GetMenuItemBySlug::class);
  });
