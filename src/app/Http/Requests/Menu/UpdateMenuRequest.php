<?php

namespace App\Http\Requests\Menu;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMenuRequest extends FormRequest
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
      'uuid' => 'required|uuid',
      'name' => 'required|string',
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
      'uuid.required'   => 'Invalid UUID.',
      'uuid.uuid'       => 'Invalid UUID.',
      'name.required'   => 'Name is required.',
      'name.string'     => 'Invalid Name.',
      'slug.required'   => 'Slug is required.',
      'slug.alpha_dash' => 'Invalid Slug.',
    ];
  }
}
