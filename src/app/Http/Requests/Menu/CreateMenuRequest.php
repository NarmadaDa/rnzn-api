<?php

namespace App\Http\Requests\Menu;

use Illuminate\Foundation\Http\FormRequest;

class CreateMenuRequest extends FormRequest
{
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      'name' => 'required|string',
      'slug' => 'required|alpha_dash|unique:menus',
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
      'name.required'   => 'Name is required.',
      'name.string'     => 'Invalid Name.',
      'slug.required'   => 'Slug is required.',
      'slug.alpha_dash' => 'Invalid Slug.',
      'slug.unique'     => 'This slug already exists.',
    ];
  }
}
