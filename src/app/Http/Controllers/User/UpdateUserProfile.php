<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdateUserProfileRequest;
use App\Models\Role;

class UpdateUserProfile extends Controller
{
  /**
   * Handle the incoming request.
   *
   * @param  \App\Http\Requests\User\UpdateUserProfileRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function __invoke(UpdateUserProfileRequest $request)
  {
    $data = $request->validated();
    $user = $request->user();
    $user->load("profile", "roles", "userRole");

    $middle = isset($data["middle_name"]) ? $data["middle_name"] : "";
    // split middle-names varying formats, including hyphens
    $split = explode(" ", str_replace("-", " ", $middle));
    foreach ($split as $s) {
      $middle .= strtoupper(substr($s, 0, 1));
    }

    $user->profile->first_name = ucfirst(strtolower($data["first_name"]));
    $user->profile->middle_name = $middle;
    $user->profile->last_name = ucfirst(strtolower($data["last_name"]));
    $user->profile->save();

    $role = Role::where("slug", $data["role"])->first();
    $user->userRole->role_id = $role->id;
    $user->userRole->save();

    return [
      "user" => $user,
    ];
  }
}
