<?php

namespace App\Http\Requests\News;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNewsPostRequest extends FormRequest
{
  /**
   * Add parameters to be validated.
   * 
   * @return array
   */
  public function all($keys = NULL)
  {
    $data = parent::all($keys);
    
    $data['uuid'] = $this->route('uuid');

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
      'uuid'    => 'required|uuid',
      'title'   => 'required|string',
      'type'    => 'required|string|exists:post_types,type',
      'content' => 'required',
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
      'uuid.required'     => 'Invalid UUID.',
      'uuid.uuid'         => 'Invalid UUID.',
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
