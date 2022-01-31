<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class ForgotPasswordRequest extends FormRequest
{
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      "email" => "required|email",
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
      "email.required" => "Email Address is required.",
      "email.email" => "Invalid Email Address.",
    ];
  }
}
