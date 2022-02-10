<?php

namespace App\Http\Requests\News;

use Illuminate\Foundation\Http\FormRequest;

class CreateNewsPostRequest extends FormRequest
{
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      'title'   => 'required|string',
      'type'    => 'required|string|exists:post_types,type',
      'content' => 'required|string',
      'summary' => 'string',
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
      'title.required'    => 'Title is required.',
      'title.string'      => 'Invalid Title.',
      'type.required'     => 'Type is required.',
      'type.string'       => 'Invalid Type.',
      'type.exists'       => 'Invalid Type.',
      'content.required'  => 'Content is required.',
      'content.string'    => 'Invalid Content.',
    ];
  }
}
