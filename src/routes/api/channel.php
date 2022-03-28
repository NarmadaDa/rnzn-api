<?php

use Illuminate\Support\Facades\Route;

Route::namespace("Channel")
  ->prefix("channels")
  ->middleware(["auth:api"])
  ->group(function () { 
    Route::as("all")->get('/', GetChannels::class);  
    Route::get("/uuid/{uuid}", GetChannelByUUID::class);
    Route::as("posts")->get("{id}/posts", ChannelPost::class);
  });

  Route::namespace("Channel")
  ->prefix("channels/post")
  ->middleware(["auth:api"])
  ->group(function () {   
    Route::as("create")->post("/", CreatePost::class);   
    Route::as("create")->post("comment", CreateComment::class);    
    Route::as("inappropriateOrDelete")->post("inappropriateOrDelete", InappropriateOrDeletePost::class); 
    Route::as("pinpost")->post("pinpost", PinPost::class);  
    Route::as("reaction")->post("reaction", CreateReaction::class);   
    Route::as("pin")->post("pin", PinPost::class); 
  });
