<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
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
      "password" => "required|confirmed|min:8",
      "code" => "required|string",
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
      "password.required" => "Password must be at least 8 characters.",
      "code.required" => "Invalid Reset Code.",
      "code.string" => "Invalid Reset Code.",
    ];
  }
}
