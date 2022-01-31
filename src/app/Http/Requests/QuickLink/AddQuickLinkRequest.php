<?php

namespace App\Http\Requests\QuickLink;

use Illuminate\Foundation\Http\FormRequest;

class AddQuickLinkRequest extends FormRequest
{
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      'menu_item_uuid'  => 'required|uuid',
      'sort_order'      => 'required|numeric|min:0',
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
      'menu_item_uuid.required' => 'Menu Item UUID is required.',
      'menu_item_uuid.uuid'     => 'Invalid Menu Item UUID.',
      'sort_order.required'     => 'Sort Order is required.',
      'sort_order.numeric'      => 'Invalid Sort Order.',
      'sort_order.min'          => 'Invalid Sort Order.',
    ];
  }
}
