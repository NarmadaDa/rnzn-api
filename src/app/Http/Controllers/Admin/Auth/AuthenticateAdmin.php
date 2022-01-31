<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Models\User;
use Laravel\Passport\Http\Controllers\AccessTokenController;
use Psr\Http\Message\ServerRequestInterface;
use Google2FA;
use Throwable;

class AuthenticateAdmin extends AccessTokenController
{
  /**
   * Handle the incoming request.
   *
   * @param  \Psr\Http\Message\ServerRequestInterface  $request
   * @return \Illuminate\Http\Response
   */
  public function __invoke(ServerRequestInterface $request)
  {
    $body = $request->getParsedBody();
    if (!isset($body["username"])) {
      abort(401, "Unauthorised.");
    }

    $email = $body["username"];
    $user = User::where("email", $email)->first();
    if (!$user->isAdmin()) {
      abort(401, "Unauthorised.");
    }

    $result = null;

    try {
      $result = $this->issueToken($request);
    } catch (Throwable $e) {
      abort(401, "Unauthorised.");
    }

    return json_decode($result->content(), true);
  }
}
