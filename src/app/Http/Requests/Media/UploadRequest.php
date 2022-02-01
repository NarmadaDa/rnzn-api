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
      // 'uuid'    => 'required|uuid',
      // 'mediable_id'   => 'required',
      // 'mediable_type'    => 'required',
      // 'type'   => 'required',
      // 'thumbnail_url'    => 'required',
      // 'url'    => 'required',
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
      'image.required'        => 'Image is required.',
      'image.file'            => 'Image must be a file',

      // 'uuid.required'         => 'Invalid device identifier.',
      // 'uuid.uuid'             => 'Invalid device identifier.',
      // 'mediable_id.required'  => 'Invalid Mediable ID.',
      // 'mediable_type.required'=> 'Invalid Mediable Type.',
      // 'type.required'         => 'Invalid Type.',
      // 'thumbnail_url.required'=> 'Invalid Thumbnail URL.',
      // 'url.required'          => 'Invalid URL.', 
    ];
  }
}
