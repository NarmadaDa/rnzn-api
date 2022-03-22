<?php

namespace App\Http\Requests\Channel;

use Illuminate\Foundation\Http\FormRequest;

class InappropriateRequest extends FormRequest
{
  /**
   * Add parameters to be validated.
   * 
   * @return array
   */
  // public function all($keys = NULL)
  // {
  //   $data = parent::all($keys);
    
  //   $data['id'] = $this->route('id');

  //   return $data;
  // }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      'uuid' => 'required|uuid',
      'type' => 'required|string',
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
      'uuid.alpha_dash' => 'Invalid UUID.',  
      'type.required'    => 'Type is required.',
      'type.string'      => 'Invalid Type.', 
    ];
  }
}