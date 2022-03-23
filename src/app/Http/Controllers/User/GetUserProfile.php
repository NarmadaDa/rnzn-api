<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ConditionAcceptUsers;

class GetUserProfile extends Controller
{
  /**
   * Handle the incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function __invoke(Request $request)
  {
    $user = $request->user();
    $user->load('profile', 'roles');


    $accepted = ConditionAcceptUsers::where("accepted_by", $user["uuid"])->exists();


    return [
      'user' => $user,
      'terms_and_conditions' => $accepted
    ];
  }
}
