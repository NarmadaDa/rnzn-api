<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Laravel\Passport\Http\Controllers\AuthorizedAccessTokenController;

class LogoutUser extends AuthorizedAccessTokenController
{
  /**
   * Handle the incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  string  $tokenId
   * @return \Illuminate\Http\Response
   */
  public function __invoke(Request $request, $tokenId)
  {
    $this->destroy($request, $tokenId);

    return [
      'message' => 'Successfully logged out.',
    ];
  }
}
