<?php

use Illuminate\Support\Facades\Route;

Route::namespace("Article")
  ->prefix("articles")
  ->middleware(["auth:api"])
  ->group(function () {
    Route::as("details")->get("{slug}", GetArticleBySlug::class);

    Route::prefix("{uuid}")->group(function () {
      Route::as("feedback")->post("feedback", SubmitArticleFeedback::class);
      Route::as("report")->post("report", ReportArticle::class);
      Route::middleware(["not.guest"])->get("download", DownloadArticle::class);
    });
  });

Route::namespace("Article")
  ->prefix("article")
  ->middleware(["auth:api"])
  ->group(function () {
    Route::as("shortlist")->get('shortlist', GetArticlesShortlist::class);
  });
