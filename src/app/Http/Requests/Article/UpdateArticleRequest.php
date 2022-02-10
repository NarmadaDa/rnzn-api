<?php

namespace App\Http\Requests\Article;

use Illuminate\Foundation\Http\FormRequest;

class UpdateArticleRequest extends FormRequest
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
      'uuid'      => 'required|uuid',
      'title'     => 'required|string',
      'slug'      => 'required|alpha_dash',
      'content'   => 'required',
      'keywords'  => 'nullable|string',
      'roles'     => 'array',
      "roles.*"   => "required|string|distinct|min:1",
      'summary'   => 'nullable',
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
      'title.required'    => 'Name is required.',
      'title.string'      => 'Invalid Name.',
      'slug.required'     => 'Slug is required.',
      'slug.alpha_dash'   => 'Invalid Slug.',
      'content.required'  => 'Content is required.',
      'keywords.string'   => 'Keywords must be a comma-separated list.',
    ];
  }
}
