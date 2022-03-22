<?php

namespace App\Http\Requests\Channel;

use Illuminate\Foundation\Http\FormRequest;

class CreateChannelRequest extends FormRequest
{
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      'name'            => 'required|string', 
      'channel_active'  => 'nullable',   
      'image'           => 'nullable', 
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
      'name.required'    => 'Channel name is required.',
      'name.string'      => 'Invalid channel name.',  
    ];
  }
}
