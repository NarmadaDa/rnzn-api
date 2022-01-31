<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SearchUsersRequest extends FormRequest
{
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      "s" => "string|nullable",
      "email" => "string|nullable",
      "first_name" => "string|nullable",
      "last_name" => "string|nullable",
      "page_size" => "integer|nullable",
      "order_col" => "nullable|in:name,email,role,status,created_at",
      "order_dir" => "nullable|in:asc,desc",
    ];
  }
}
