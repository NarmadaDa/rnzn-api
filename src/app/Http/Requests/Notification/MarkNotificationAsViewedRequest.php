<?php

namespace App\Http\Requests\Notification;

use Illuminate\Foundation\Http\FormRequest;

class MarkNotificationAsViewedRequest extends FormRequest
{
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      'uuid' => 'required|uuid',
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
      'uuid.required'   => 'Invalid UUID.',
      'uuid.alpha_dash' => 'Invalid UUID.',
    ];
  }
}
