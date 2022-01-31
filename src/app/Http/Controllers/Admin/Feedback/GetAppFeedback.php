<?php

namespace App\Http\Controllers\Admin\Feedback;

use App\Http\Controllers\PaginatedController;
use App\Models\UserFeedback;
use Illuminate\Http\Request;

class GetAppFeedback extends PaginatedController
{
  /**
   * Handle the incoming request.
   *
   * @param  Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function __invoke(Request $request)
  {
    $size = $request->get("page_size", 10);

    return $this->paginate("app_feedback", UserFeedback::paginate($size));
  }
}
