<?php

namespace App\Http\Requests\Device;

use Illuminate\Foundation\Http\FormRequest;

class AddDeviceRequest extends FormRequest
{
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      'type' => 'required|in:android,ios,web',
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
      'type.required' => 'Invalid type.',
      'type.in'       => 'Invalid type.',
    ];
  }
}
