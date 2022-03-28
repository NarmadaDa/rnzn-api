<?php

namespace App\Http\Requests\Channel;

use Illuminate\Foundation\Http\FormRequest;

class PinPostRequest extends FormRequest
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
  // public function rules()
  // {
  //   return [
  //     'channel_id' => 'required',
  //     'post' => 'required|string',
  //   ];
  // }

  // /**
  //  * Get the error messages for the defined validation rules.
  //  *
  //  * @return array
  //  */
  // public function messages()
  // {
  //   return [
  //     'channel_id.required'   => 'Channel ID is required.',
  //     'post.required'    => 'Post is required.',
  //     'post.string'      => 'Invalid post.',   
  //   ];
  // }
}
