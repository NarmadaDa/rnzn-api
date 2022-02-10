<?php

namespace App\Http\Requests\Article;

use Illuminate\Foundation\Http\FormRequest;

class CreateArticleRequest extends FormRequest
{
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      'title'     => 'required|string',
      'slug'      => 'required|string|unique:articles',
      'content'   => 'required|string',
      'keywords'  => 'nullable|string',
      'roles'     => 'required|array|min:1|in:personnel,family,guest',
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
      'title.required'    => 'Title is required.',
      'title.string'      => 'Invalid Title.',
      'slug.required'     => 'Slug is required.',
      'slug.string'       => 'Invalid Slug.',
      'slug.unique'       => 'This slug already exists.',
      'content.required'  => 'Content is required.',
      'content.required'  => 'Content is required.',
      'content.string'    => 'Invalid Content.',
      'keywords.string'   => 'Keywords must be a comma-separated list.',
      'roles.required'    => 'An array with at least one Role is required.',
      'roles.array'       => 'An array with at least one Role is required.',
      'roles.min'         => 'An array with at least one Role is required.',
      'roles.in'          => 'Invalid Roles.',
    ];
  }
}
