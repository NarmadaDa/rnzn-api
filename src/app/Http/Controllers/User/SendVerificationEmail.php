<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class SendVerificationEmail extends Controller
{
  /**
   * Handle the incoming request.
   *
   * @return \Illuminate\Http\Response
   */
  public function __invoke()
  {
    return [
      'message' => 'Please verify your email address.',
    ];
  }
}
