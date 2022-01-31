<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ResendVerificationEmail extends Controller
{
  /**
   * Handle the incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function __invoke(Request $request)
  {
    $user = $request->user();
    if (!$user) {
      abort(401, "Unauthorised.");
    }

    if ($user->hasVerifiedEmail()) {
      abort(400, "Email address has already been verified.");
    }

    $request->user()->sendEmailVerificationNotification();

    return [
      "message" => "Verification link sent.",
    ];
  }
}
