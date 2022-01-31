<?php

namespace App\Http\Controllers\Admin\Social;

use App\Http\Controllers\Controller;
use App\Models\SocialAccount;
use App\Http\Requests\Social\FBRemovePageRequest;
use Log;

class FBRemovePage extends Controller
{
  /**
   * Handle the incoming request.
   *
   * @param  \App\Http\Requests\Social\FBRemovePageRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function __invoke(FBRemovePageRequest $request)
  {
    Log::info("-> FBRemovePageRequest");

    $data = $request->validated();

    $account = SocialAccount::where("uuid", $data["uuid"])->first();
    if (!$account) {
      Log::error("Failed to find Social Account with uuid");
      abort(404, "An error occurred");
    }

    $account->sessions()->delete();
    $account->delete();

    return [
      "message" => "The Facebook page and related content has been deleted",
    ];
  }
}
