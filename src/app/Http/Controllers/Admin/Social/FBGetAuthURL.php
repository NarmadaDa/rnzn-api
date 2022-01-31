<?php

namespace App\Http\Controllers\Admin\Social;

use App\Http\Controllers\Controller;
use App\Models\SocialAccount;
use Log;

class FBGetAuthURL extends Controller
{
  /**
   * Handle the incoming request.
   *
   * @return \Illuminate\Http\Response
   */
  public function __invoke()
  {
    Log::info("-> FBGetAuthURL");

    $account = SocialAccount::create([
      "type" => "facebook_page",
    ]);

    $clientID = config("social.facebook.client_id");
    $redirectUrl = config("app.url") . "/api/v1/social/facebook/webhooks/login";

    $url =
      "https://www.facebook.com/v9.0/dialog/oauth" .
      "?client_id=" .
      $clientID .
      "&redirect_uri=" .
      $redirectUrl .
      "&state=" .
      $account->uuid .
      "&scope=pages_show_list,pages_read_engagement";

    return [
      "auth_url" => $url,
    ];
  }
}
