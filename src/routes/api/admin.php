<?php

use Illuminate\Support\Facades\Route;

Route::namespace("Admin")
  ->prefix("admin")
  ->middleware(["auth:api", "role.admin"])
  ->group(function () {
    // Route::middleware(["2fa"])->group(function () {
      // endpoints restricted behind 2fa
      Route::as("stats")->get("stats", GetAdminStats::class); 

      Route::as("feedback.")
        ->namespace("Feedback")
        ->prefix("feedback")
        ->group(function () {
          Route::as("app")->get("app", GetAppFeedback::class);
          Route::as("articles")->get("articles", GetArticleFeedback::class);
        });

      Route::as("articles.")
        ->namespace("Article")
        ->prefix("articles")
        ->group(function () {
          Route::as("sort")->post("sort", ShortlistArticleSort::class);  
          Route::get("/", GetArticles::class);
          Route::get("/uuid/{uuid}", GetArticleByUUID::class);
          Route::as("create")->post("/", CreateArticle::class);
          Route::as("delete")->delete("{uuid}", DeleteArticle::class);
          Route::as("update")->post("{uuid}", UpdateArticle::class);
          Route::as("shortlist_order")->get('shortlist_order', GetArticlesShortlistOrder::class);   
        });

        Route::as("articles_shortlist.")
          ->namespace("Article")
          ->prefix("articles_shortlist")
          ->group(function () {
            Route::as("delete")->delete("{uuid}", DeleteArticleShortlist::class);
          });

      Route::as("menus.")
        ->namespace("Menu")
        ->prefix("menus")
        ->group(function () {
          Route::get("/", GetMenus::class);
          Route::as("create")->post("/", CreateMenu::class);
          Route::as("delete")->delete("{uuid}", DeleteMenu::class);
          Route::as("update")->post("{uuid}", UpdateMenu::class);
        });

      Route::as("items.")
        ->namespace("MenuItem")
        ->prefix("menus/{menu_uuid}/items")
        ->group(function () {
          Route::as("create")->post("/", CreateMenuItem::class);
          Route::as("delete")->delete("{uuid}", DeleteMenuItem::class);
          Route::as("update")->post("{uuid}", UpdateMenuItem::class);
        });

      Route::as("news.")
        ->namespace("News")
        ->prefix("news")
        ->group(function () {
          Route::get("/search", SearchPosts::class);
          Route::as("create")->post("/", CreateNewsPost::class);
          Route::as("delete")->delete("{uuid}", DeleteNewsPost::class);
          Route::as("update")->post("{uuid}", UpdateNewsPost::class);
        });

      Route::as("settings.")
        ->namespace("Settings")
        ->prefix("settings")
        ->group(function () {
          Route::as("2fa.")
            ->prefix("2fa")
            ->group(function () {
              Route::as("verify")->post("verify", Verify2FAOTP::class);
            });
        });

      Route::as("social.")
        ->namespace("Social")
        ->prefix("social")
        ->group(function () {
          Route::get("/account/{uuid}", FBGetPosts::class);
          Route::as("facebook.")
            ->prefix("facebook")
            ->group(function () {
              Route::as("authorise")->get("auth", FBGetAuthURL::class);

              Route::as("sessions.")
                ->prefix("sessions/{uuid}")
                ->group(function () {
                  Route::as("pages")->get("pages", FBGetListOfPages::class);
                  Route::as("refresh")->get(
                    "refresh",
                    FBRefreshPageData::class
                  );
                  Route::as("remove")->delete("/", FBRemovePage::class);

                  Route::as("tokens.")
                    ->prefix("tokens")
                    ->group(function () {
                      Route::as("swap")->get(
                        "upgrade",
                        FBSwapCodeForAccessToken::class
                      );
                      Route::as("user")->get(
                        "user",
                        FBGetLongLivedUserToken::class
                      );
                      Route::as("page")->post(
                        "page",
                        FBGetLongLivedTokenForPage::class
                      );
                    });
                });
            });
        });

      Route::as("users.")
        ->namespace("User")
        ->prefix("users")
        ->group(function () {
          Route::as("create")->post("/", CreateUser::class);
          Route::as("search")->get("search", SearchUsers::class);
          Route::as("update")->post("{uuid}", UpdateUser::class);
          Route::as("approve")->post("{uuid}/approve", ApproveUser::class);
          Route::as("delete")->delete("{uuid}", DeleteUser::class);
        });

    // });

    Route::as("settings.")
      ->namespace("Settings")
      ->prefix("settings")
      ->group(function () {
        Route::as("2fa.")
          ->prefix("2fa")
          ->group(function () {
            Route::as("qrcode")->get("qrcode", Get2FAQRCode::class);
          });
      });
  });
