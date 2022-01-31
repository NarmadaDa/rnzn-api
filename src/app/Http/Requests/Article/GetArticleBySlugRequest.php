<?php

namespace App\Http\Requests\Article;

use Illuminate\Foundation\Http\FormRequest;

class GetArticleBySlugRequest extends FormRequest
{
  /**
   * Add parameters to be validated.
   * 
   * @return array
   */
  public function all($keys = NULL)
  {
    $data = parent::all($keys);
    
    $data['slug'] = $this->route('slug');

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
      'slug' => 'required|alpha_dash',
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
      'slug.required'   => 'Slug is required.',
      'slug.alpha_dash' => 'Invalid Slug.',
    ];
  }
}
