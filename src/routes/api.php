<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
// Route::get("test_version", GetVersion::class);
Route::prefix("v1")->group(function () {
  // miscellaneous
  Route::namespace("Config")->group(function () {
    Route::get("version", GetVersion::class);
  });

  // Route::get('/openssl', function () {
  //   dd(openssl_get_cert_locations());
  // });

  // email verification
  Route::namespace("User")
    ->as("verification.")
    ->prefix("email")
    ->group(function () {
      Route::name("notice")->get("verify", SendVerificationEmail::class);
      Route::name("resend")->get("resend", ResendVerificationEmail::class);
    });

  // no device identifier required
  Route::as("device.")->group(__DIR__ . "/api/device.php");
  Route::as("social.")->group(__DIR__ . "/api/social.php");

  // device identifier required
  Route::middleware(["device.verify"])->group(function () {
    Route::as("admin.")->group(__DIR__ . "/api/admin.php");
    Route::as("article.")->group(__DIR__ . "/api/article.php");
    Route::as("guest.")->group(__DIR__ . "/api/guest.php");
    Route::as("media.")->group(__DIR__ . "/api/media.php");
    Route::as("menu.")->group(__DIR__ . "/api/menu.php");
    Route::as("news.")->group(__DIR__ . "/api/news.php");
    Route::as("notifications.")->group(__DIR__ . "/api/notification.php");
    // Route::as("quicklink.")->group(__DIR__ . "/api/quicklink.php");
    Route::as("user.")->group(__DIR__ . "/api/user.php");
  });
});
