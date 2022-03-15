<?php

namespace App\Http\Requests\Conditions;

use Illuminate\Foundation\Http\FormRequest;

class UpdateConditionRequest extends FormRequest
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
      'uuid'            => 'required|uuid', 
      'condition_id'    =>  'required',  
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
      'uuid.required'         => 'Invalid UUID.',
      'uuid.uuid'             => 'Invalid UUID.',
      'condition_id.required' => 'Condition ID is required.',
    ];
  }
}
