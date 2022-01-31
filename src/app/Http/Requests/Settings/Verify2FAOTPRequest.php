<?php

namespace App\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;

class Verify2FAOTPRequest extends FormRequest
{
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      'google_2fa_otp' => 'required|string',
    ];
  }

  /**
   * Get the error messages for the defined validation rules.
   *
   * @return array
   */
  public function messages()
  {
    return [
      'google_2fa_otp.required'  => 'google_2fa_otp is required.',
      'google_2fa_otp.string'    => 'Invalid 2FA OTP.',
    ];
  }
}
