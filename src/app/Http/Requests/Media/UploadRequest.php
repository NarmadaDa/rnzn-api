<?php

namespace App\Http\Requests\Media;

use Illuminate\Foundation\Http\FormRequest;

class UploadRequest extends FormRequest
{
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      'image'   => 'required|file',
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
      'image.required'    => 'Image is required.',
      'image.file'      => 'Image must be a file',
    ];
  }
}
