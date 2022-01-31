<?php

namespace App\Http\Requests\Social;

use Illuminate\Foundation\Http\FormRequest;

class FBGetLongLivedTokenForPageRequest extends FormRequest
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
      'page_id' => 'integer',
      'uuid'    => 'required|uuid',
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
      'page_id.integer' => 'Invalid Page ID.',
      'uuid.required'   => 'Invalid UUID.',
      'uuid.uuid'       => 'Invalid UUID.',
    ];
  }
}
