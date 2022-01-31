<?php

namespace App\Http\Requests\Social;

use Illuminate\Foundation\Http\FormRequest;

class GetSocialPostsRequest extends FormRequest
{
  /**
   * Add parameters to be validated.
   * 
   * @return array
   */
  public function all($keys = NULL)
  {
    $data = parent::all($keys);
    
    $data['social_accounts'] = $this->query('social_accounts');

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
      'social_accounts' => 'nullable|array',
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
      'social_accounts.array' => 'Social Accounts must be an array of IDs.',
    ];
  }
}
