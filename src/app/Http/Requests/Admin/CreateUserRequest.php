<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
{
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      "email" => "required|email:rfc,dns|unique:users|not_regex:/((\.)mil(\.)nz)/u",
      "first_name" => "required|string",
      "middle_name" => "nullable|string",
      "last_name" => "required|string",
      "role" => "required|in:guest,family,personnel,admin,super",
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
      "email.not_regex" => "Please do not use a Military email.",
      "first_name.required" => "First Name is required.",
      "first_name.string" => "Invalid First Name.",
      "middle_name.string" => "Invalid Middle Name.",
      "last_name.required" => "Last Name is required.",
      "last_name.string" => "Invalid Last Name.",
      "role.required" => "Role is required.",
      "role.in" => "Invalid Role.",
    ];
  }
}
