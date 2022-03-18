<?php

namespace App\Http\Requests\Channel;

use Illuminate\Foundation\Http\FormRequest;

class CreatePostRequest extends FormRequest
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
      'channel_id' => 'required',
      'post' => 'required|string',
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
      'channel_id.required'   => 'Channel ID is required.',
      'post.required'    => 'Post is required.',
      'post.string'      => 'Invalid post.',   
    ];
  }
}
