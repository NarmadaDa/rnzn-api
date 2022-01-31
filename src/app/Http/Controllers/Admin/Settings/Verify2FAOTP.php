<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\Verify2FAOTPRequest;
use Google2FA;
use Throwable;

class Verify2FAOTP extends Controller
{
  /**
   * Handle the incoming request.
   *
   * @param  \App\Http\Requests\Settings\Verify2FAOTPRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function __invoke(Verify2FAOTPRequest $request)
  {
    $data = $request->validated();
    $user = $request->user();

    try {
      $verified = Google2FA::verifyGoogle2FA(
        $user->google2FASecret(),
        $data["google_2fa_otp"]
      );
      if (!$verified) {
        abort(422, "Invalid 2FA OTP.");
      }
    } catch (Throwable $e) {
      abort(422, "Invalid 2FA OTP.");
    }

    return [
      "message" => "2FA verified.",
    ];
  }
}
