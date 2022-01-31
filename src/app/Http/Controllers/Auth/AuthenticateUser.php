<?php

namespace App\Http\Controllers\Auth;

use App\Models\PasswordReset;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use Laravel\Passport\Http\Controllers\AccessTokenController;
use Psr\Http\Message\ServerRequestInterface;
use Throwable;

class AuthenticateUser extends AccessTokenController
{
  /**
   * Handle the incoming request.
   *
   * @param  \Psr\Http\Message\ServerRequestInterface  $request
   * @return \Illuminate\Http\Response
   */
  public function __invoke(ServerRequestInterface $request)
  {
    $result = null;

    $body = $request->getParsedBody(); 

    try {
      $result = $this->issueToken($request);
      return json_decode($result->content(), true);
    } catch (Throwable $e) {
      $result = null;
      if ($body["grant_type"] === "refresh_token") {
        abort(401, "Invalid refresh token.");
      }
    }

    $body = $request->getParsedBody(); 
 

    $email = $body["username"];
    $password = $body["password"];

    // check if the email address even exists
    $user = User::where("email", $email)->first();
    if (!$user) {
      return $this->abortUnauthorised();
    }

    // check if a temporary password exists
    $reset = PasswordReset::where("email", $email)->first();
    if (!$reset) {
      return $this->abortUnauthorised();
    }

    // check if the password provided is correct
    if (!Hash::check($password, $reset->code)) {
      return $this->abortUnauthorised();
    }

    abort(410, "Password reset required.");
  }

  private function abortUnauthorised()
  {
    abort(401, "Incorrect email or password.");
  }
}
