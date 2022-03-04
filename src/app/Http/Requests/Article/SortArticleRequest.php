<?php

namespace App\Http\Requests\Article;

use Illuminate\Foundation\Http\FormRequest;

class SortArticleRequest extends FormRequest
{
  /**
   * Add parameters to be validated.
   * 
   * @return array
   */

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [ 
      "order"    => "required|array", 
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
      'order.required'    => 'An array with at least one order is required.', 
    ];
  }
}
