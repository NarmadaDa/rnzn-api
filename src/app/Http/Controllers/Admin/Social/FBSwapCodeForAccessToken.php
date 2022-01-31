<?php

namespace App\Http\Controllers\Admin\Social;

use App\Http\Controllers\Controller;
use App\Http\Requests\Social\FBSwapCodeForAccessTokenRequest;
use App\Models\SocialAccount;
use Http;
use Log;

class FBSwapCodeForAccessToken extends Controller
{
  /**
   * Handle the incoming request.
   *
   * @param  \App\Http\Requests\Social\FBSwapCodeForAccessTokenRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function __invoke(FBSwapCodeForAccessTokenRequest $request)
  {
    Log::info("-> FBSwapCodeForAccessToken");

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

    if (!empty($user_access_token)) {
      return $this->performRedirect($data["uuid"]);
    }

    $clientID = config("social.facebook.client_id");
    $clientSecret = config("social.facebook.client_secret");
    $redirectUrl = config("app.url") . "/api/v1/social/facebook/webhooks/login";

    $url =
      "https://graph.facebook.com/v9.0/oauth/access_token" .
      "?client_id=" .
      $clientID .
      "&client_secret=" .
      $clientSecret .
      "&redirect_uri=" .
      $redirectUrl .
      "&code=" .
      $session->code;

    $response = Http::get($url);
    $json = $response->json();
    // Log::info($json);

    if (!isset($json["access_token"])) {
      // something went wrong, invalidate the session
      Log::error("Facebook auth failed");
      abort(400, "An error occurred");
    }

    $session->user_access_token = $json["access_token"];
    $session->save();

    // redirect to get long lived user token
    return $this->performRedirect($data["uuid"]);
  }

  public function performRedirect($uuid)
  {
    return redirect()->route("admin.social.facebook.sessions.tokens.user", [
      "uuid" => $uuid,
    ]);
  }
}
