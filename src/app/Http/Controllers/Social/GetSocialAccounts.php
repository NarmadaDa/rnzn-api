<?php

namespace App\Http\Controllers\Social;

use App\Http\Controllers\Controller;
use App\Models\SocialAccount;
use Http;
use Log;

class GetSocialAccounts extends Controller
{
  /**
   * Handle the incoming request.
   *
   * @return \Illuminate\Http\Response
   */
  public function __invoke()
  {
    Log::info("-> GetSocialAccounts");

    $accounts = SocialAccount::authorisedAccounts()->get();

    // return list of pages
    return [
      'social_accounts' => $accounts
    ];
  }
}
