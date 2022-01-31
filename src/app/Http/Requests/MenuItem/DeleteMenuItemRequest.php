<?php

namespace App\Http\Requests\MenuItem;

use Illuminate\Foundation\Http\FormRequest;

class DeleteMenuItemRequest extends FormRequest
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
      'menu_uuid' => 'required|uuid',
      'uuid' => 'required|uuid',
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
      'menu_uuid.required'    => 'Invalid Menu UUID.',
      'menu_uuid.alpha_dash'  => 'Invalid Menu UUID.',
      'uuid.required'         => 'Invalid UUID.',
      'uuid.alpha_dash'       => 'Invalid UUID.',
    ];
  }
}
