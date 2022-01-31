<?php

namespace App\Http\Controllers\Admin\Social;

use App\Http\Controllers\Controller;
use App\Models\SocialAccount;
use App\Http\Requests\Social\FBGetListOfPagesRequest;
use Http;
use Log;

class FBGetListOfPages extends Controller
{
  /**
   * Handle the incoming request.
   *
   * @param  \App\Http\Requests\Social\FBGetListOfPagesRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function __invoke(FBGetListOfPagesRequest $request)
  {
    Log::info("-> FBGetListOfPages");

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

    $url =
      "https://graph.facebook.com/v9.0/me" .
      "?fields=accounts{id,name,picture{url}}" .
      "&access_token=" .
      $session->long_lived_user_token;

    $response = Http::get($url);
    $json = $response->json();
    // Log::info($json);

    if (!isset($json["accounts"]) || !isset($json["accounts"]["data"])) {
      // something went wrong, invalidate the session
      $session->delete();
      Log::error("Facebook session has no pages authorised");
      abort(400, "An error occurred");
    }

    $result = [];
    foreach ($json["accounts"]["data"] as $account) {
      $result[] = [
        "id" => $account["id"],
        "name" => $account["name"],
        "picture_url" => $account["picture"]["data"]["url"],
      ];
    }

    // return list of pages
    return $result;
  }
}
