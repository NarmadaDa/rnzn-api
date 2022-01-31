<?php

namespace App\Http\Requests\MenuItem;

use Illuminate\Foundation\Http\FormRequest;

class GetMenuItemBySlugRequest extends FormRequest
{
  /**
   * Add parameters to be validated.
   * 
   * @return array
   */
  public function all($keys = NULL)
  {
    $data = parent::all($keys);
    
    $data['menu_uuid'] = $this->route('menu_uuid');
    $data['slug'] = $this->route('slug');

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
      'menu_uuid' => 'required|uuid',
      'slug' => 'required|alpha_dash',
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
      'menu_uuid.required'  => 'Invalid Menu UUID.',
      'menu_uuid.uuid'      => 'Invalid Menu UUID.',
      'slug.required'       => 'Slug is required.',
      'slug.alpha_dash'     => 'Invalid Slug.',
    ];
  }
}
