<?php

namespace App\Http\Requests\Article;

use Illuminate\Foundation\Http\FormRequest;

class ReportArticleRequest extends FormRequest
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
      "message" => "required|string|min:20,max:1000",
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
      "message.required" => "Message is required.",
      "message.string" => "Invalid Message.",
      "message.min" => "Message must be 20 characters or more.",
      "message.max" => "Message must be 1000 characters or less.",
    ];
  }
}
