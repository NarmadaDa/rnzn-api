<?php

namespace App\Http\Requests\Social;

use Illuminate\Foundation\Http\FormRequest;

class FBLoginCallbackRequest extends FormRequest
{
  /**
   * Add parameters to be validated.
   * 
   * @return array
   */
  public function all($keys = NULL)
  {
    $data = parent::all($keys);
    
    $data['access_token'] = $this->query('access_token');
    $data['code'] = $this->query('code');
    $data['error'] = $this->query('error');
    $data['error_description'] = $this->query('error_description');
    $data['error_reason'] = $this->query('error_reason');
    $data['state'] = $this->query('state');

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
      'code' => 'nullable|string',
      'error' => 'nullable|string',
      'error_reason' => 'nullable|string',
      'error_description' => 'nullable|string',
      'state' => 'nullable|string',
      'access_token' => 'nullable|string',
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
      'code.string' => 'Invalid Code.',
      'error.string' => 'Invalid Error.',
      'error_description.string' => 'Invalid Error Description.',
      'error_reason.string' => 'Invalid Error Reason.',
      'state.string' => 'Invalid State.',
      'access_token.string' => 'Invalid Access Token.',
    ];
  }
}
