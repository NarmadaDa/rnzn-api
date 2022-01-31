<?php

namespace App\Http\Controllers\Admin\Social;

use App\Events\FBPageAuthorised;
use App\Http\Controllers\Controller;
use App\Http\Requests\Social\FBGetLongLivedTokenForPageRequest;
use App\Models\SocialAccount;
use Http;
use Log;

class FBGetLongLivedTokenForPage extends Controller
{
  /**
   * Handle the incoming request.
   *
   * @param  \App\Http\Requests\Social\FBGetLongLivedTokenForPageRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function __invoke(FBGetLongLivedTokenForPageRequest $request)
  {
    Log::info("-> FBGetLongLivedTokenForPage");

    $data = $request->validated();

    $account = SocialAccount::where("uuid", $data["uuid"])->first();
    if (!$account) {
      Log::error("Failed to find Social Account with uuid");
      abort(404, "An error occurred");
    }

    if (!empty($account->social_id)) {
      return $this->performRedirect();
    }

    $session = $account->sessions()->first();
    if (!$session) {
      Log::error("Failed to find Session for Social Account");
      abort(400, "An error occurred");
    }

    $url =
      "https://graph.facebook.com/v9.0/me/accounts" .
      "?access_token=" .
      $session->long_lived_user_token;

    $response = Http::get($url);
    $json = $response->json();
    // Log::info($json);

    if (!isset($json["data"])) {
      // something went wrong, invalidate the session
      $session->delete();
      Log::error("Facebook auth failed");
      abort(400, "An error occurred");
    }

    $result = null;
    foreach ($json["data"] as $p) {
      if ($p["id"] == $data["page_id"]) {
        $result = $p;
        break;
      }
    }

    $session->long_lived_page_token = $result["access_token"];
    $session->save();

    SocialAccount::where("social_id", $result["id"])->delete();

    $account->name = $result["name"];
    $account->social_id = $result["id"];
    $account->save();

    FBPageAuthorised::dispatch($account);

    return $this->performRedirect();
  }

  public function performRedirect()
  {
    return [
      "message" => "Facebook Page successfully authorised",
    ];
  }
}
