<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class PostUserFeedbackRequest extends FormRequest
{
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      "rating" => "required|numeric|min:0|max:10",
      "recommendation" => "required|numeric|min:0|max:10",
      "positives" => "nullable|string|max:1000",
      "improvements" => "nullable|string|max:1000",
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
      "rating.required" => "Rating is required.",
      "rating.numeric" => "Rating must be a number between 0 and 10.",
      "rating.min" => "Rating must be a number between 0 and 10.",
      "rating.max" => "Rating must be a number between 0 and 10.",
      "recommendation.required" => "Recommendation is required.",
      "recommendation.numeric" =>
        "Recommendation must be a number between 0 and 10.",
      "recommendation.min" =>
        "Recommendation must be a number between 0 and 10.",
      "recommendation.max" =>
        "Recommendation must be a number between 0 and 10.",
      "positives.string" => "Positives must be a string.",
      "positives.max" => "Positives must be less than 1000 characters.",
      "improvements.string" => "Improvements must be a string.",
      "improvements.max" => "Positives must be less than 1000 characters.",
    ];
  }
}
