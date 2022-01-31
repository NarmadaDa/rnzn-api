<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ApproveUserRequest extends FormRequest
{
  /**
   * Add parameters to be validated.
   *
   * @return array
   */
  public function all($keys = null)
  {
    $data = parent::all($keys);

    $data["uuid"] = $this->route("uuid");

    return $data;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      "uuid" => "required|uuid",
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
      "uuid.required" => "Invalid UUID.",
      "uuid.uuid" => "Invalid UUID.",
      "role.required" => "Role is required.",
      "role.in" => "Invalid Role.",
    ];
  }
}
