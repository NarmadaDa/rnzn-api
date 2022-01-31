<?php

namespace App\Http\Controllers\Social;

use App\Http\Controllers\Controller;
use App\Http\Requests\Social\FBLoginCallbackRequest;
use App\Models\SocialAccount;
use App\Models\SocialAuthSession;
use Log;
use Str;

class FBAuthCallback extends Controller
{
  /**
   * Handle the incoming request.
   *
   * @param  \App\Http\Requests\Social\FBLoginCallbackRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function __invoke(FBLoginCallbackRequest $request)
  {
    Log::info("-> FBLoginCallback");

    $data = $request->validated();

    // find the account based on the returned state (uuid)
    $account = SocialAccount::where("uuid", $data["state"])->first();
    if (!$account) {
      Log::error("Failed to find Social Account with uuid");
      abort(400, "An error occurred");
    }

    if ($data["code"] == "") {
      Log::error("Facebook auth failed");
      abort(400, "An error occurred");
    }

    // delete old sessions
    $account->sessions()->delete();

    // create the session record
    $session = SocialAuthSession::create([
      "social_account_id" => $account->id,
      "code" => $data["code"],
    ]);

    // redirect to swap code for access token
    return redirect()->route("admin.social.facebook.sessions.tokens.swap", [
      "uuid" => $data["state"],
    ]);
  }
}
