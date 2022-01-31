<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\PostUserFeedbackRequest;
use App\Models\UserFeedback;
use Carbon\Carbon;

class PostUserFeedback extends Controller
{
  /**
   * Handle the incoming request.
   *
   * @param  \App\Http\Requests\User\PostUserFeedbackRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function __invoke(PostUserFeedbackRequest $request)
  {
    $data = $request->validated();
    $user = $request->user();

    $today = Carbon::today()->subDays(1);
    $feedback = $user
      ->feedback()
      ->whereDate("created_at", ">", $today)
      ->first();

    if ($feedback) {
      abort(429, "You can only submit feedback once every 24 hours.");
    }

    UserFeedback::create([
      "user_id" => $user->id,
      "rating" => $data["rating"],
      "recommendation" => $data["recommendation"],
      "positives" => $data["positives"],
      "improvements" => $data["improvements"],
    ]);

    return [
      "message" => "Thank you for your feedback.",
    ];
  }
}
