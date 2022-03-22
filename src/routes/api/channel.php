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
    Route::as("inappropriate")->post("inappropriate", InappropriatePost::class);  
    Route::as("reply")->post("replypost", CreateComment::class);  
  });
