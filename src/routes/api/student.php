<?php

use Illuminate\Support\Facades\Route;

Route::namespace("Student")
  ->prefix("student")
  ->middleware(["auth:api"])
  ->group(function () {
    Route::as("all")->get("", GetAllStudents::class);
    Route::as("update")->post("", UpdateStudentMarks::class);  
  });
