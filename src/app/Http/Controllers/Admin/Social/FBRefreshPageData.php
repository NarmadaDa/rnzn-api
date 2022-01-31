<?php

namespace App\Http\Controllers\Admin\Social;

use App\Events\FBPageAuthorised;
use App\Http\Controllers\Controller;
use App\Http\Requests\Social\FBRefreshPageDataRequest;
use App\Models\SocialAccount;
use Log;

class FBRefreshPageData extends Controller
{
  /**
   * Handle the incoming request.
   *
   * @param  \App\Http\Requests\Social\FBRefreshPageDataRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function __invoke(FBRefreshPageDataRequest $request)
  {
    Log::info("-> FBRefreshPageData");

    $data = $request->validated();

    $account = SocialAccount::where("uuid", $data["uuid"])->first();
    if (!$account) {
      Log::error("Failed to find Social Account with uuid");
      abort(404, "An error occurred");
    }

    FBPageAuthorised::dispatch($account);

    return [
      "message" => "Refreshing social posts for Facebook page",
    ];
  }
}
