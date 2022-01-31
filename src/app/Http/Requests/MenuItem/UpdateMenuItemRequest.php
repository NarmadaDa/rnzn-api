<?php

namespace App\Http\Requests\MenuItem;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMenuItemRequest extends FormRequest
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
      'menu_uuid'   => 'required|uuid',
      'uuid'        => 'required|uuid',
      'title'       => 'required|string',
      'slug'        => 'required|alpha_dash',
      'sort_order'  => 'required|numeric|min:0',
      'item_type'   => 'required|in:article,menu',
      'item_uuid'   => 'required|uuid',
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
      'uuid.required'       => 'Invalid UUID.',
      'uuid.uuid'           => 'Invalid UUID.',
      'title.required'      => 'Name is required.',
      'title.string'        => 'Invalid Name.',
      'slug.required'       => 'Slug is required.',
      'slug.alpha_dash'     => 'Invalid Slug.',
      'sort_order.required' => 'Sort Order is required.',
      'sort_order.numeric'  => 'Invalid Sort Order.',
      'sort_order.min'      => 'Invalid Sort Order.',
      'item_type.required'  => 'Item Type is required.',
      'item_type.in'        => 'Invalid Item Type.',
      'item_uuid.required'  => 'Item UUID is required.',
      'item_uuid.uuid'      => 'Invalid Item UUID.',
    ];
  }
}
