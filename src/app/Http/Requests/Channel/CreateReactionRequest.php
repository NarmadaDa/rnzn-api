<?php

namespace App\Http\Requests\Channel;

use Illuminate\Foundation\Http\FormRequest;

class CreateReactionRequest extends FormRequest
{

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      'uuid' => 'required|uuid',
      'emoji' => 'required|string',
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
      'emoji.required'  => 'Emoji ID is required.', 
      'emoji.string'   => 'Invalid emoji.',
    ];
  }
}
