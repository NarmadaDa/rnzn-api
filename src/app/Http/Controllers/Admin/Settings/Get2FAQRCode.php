<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use Google2FA;
use Illuminate\Http\Request;

class Get2FAQRCode extends Controller
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

    if (!$user->isAdmin()) {
      abort(401, "Unauthorised.");
    }

    if ($user->is2faReady()) {
      abort(403, "User has already enabled 2FA.");
    }

    $secret = Google2FA::generateSecretKey();
    $user->preferences->google_2fa_secret = $secret;
    $user->preferences->save();

    $qrcode = Google2FA::getQRCodeUrl("RNZN HomePort", $user->email, $secret);

    return [
      "qrcode_url" => $qrcode,
    ];
  }
}
