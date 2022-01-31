<?php

namespace App\Http\Controllers\Admin\Social;

use App\Http\Controllers\Controller;
use App\Http\Requests\Social\FBGetLongLivedUserTokenRequest;
use App\Models\SocialAccount;
use Http;
use Log;

class FBGetLongLivedUserToken extends Controller
{
  /**
   * Handle the incoming request.
   *
   * @param  \App\Http\Requests\Social\FBGetLongLivedUserTokenRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function __invoke(FBGetLongLivedUserTokenRequest $request)
  {
    Log::info("-> FBGetLongLivedUserToken");

    $data = $request->validated();

    $account = SocialAccount::where("uuid", $data["uuid"])->first();
    if (!$account) {
      Log::error("Failed to find Social Account with uuid");
      abort(404, "An error occurred");
    }

    $session = $account->sessions()->first();
    if (!$session) {
      Log::error("Failed to find Session for Social Account");
      abort(400, "An error occurred");
    }

    $clientID = config("social.facebook.client_id");
    $clientSecret = config("social.facebook.client_secret");

    $url =
      "https://graph.facebook.com/v9.0/oauth/access_token" .
      "?grant_type=fb_exchange_token" .
      "&client_id=" .
      $clientID .
      "&client_secret=" .
      $clientSecret .
      "&fb_exchange_token=" .
      $session->user_access_token;

    $response = Http::get($url);
    $json = $response->json();
    // Log::info($json);

    if (!isset($json["access_token"])) {
      // something went wrong, invalidate the session
      $session->delete();
      Log::error("Facebook auth failed");
      abort(400, "An error occurred");
    }

    $session->long_lived_user_token = $json["access_token"];
    $session->save();

    $url = config("app.dashboard_url") . "/social/facebook/" . $data["uuid"];

    // redirect to web app
    return redirect()->to($url);
  }
}
