<?php

namespace App\Http\Requests\QuickLink;

use Illuminate\Foundation\Http\FormRequest;

class SearchQuickLinkOptionsRequest extends FormRequest
{
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      'query' => 'string',
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
      'query.string' => 'Invalid Query.',
    ];
  }
}
