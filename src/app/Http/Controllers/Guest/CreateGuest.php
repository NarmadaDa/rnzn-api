<?php

namespace App\Http\Controllers\Guest;

use App\HomePort;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Preferences;
use DB;
use Hash;
use Illuminate\Http\Request;

class CreateGuest extends Controller
{
  /**
   * Handle the incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function __invoke(Request $request)
  {
    $header = HomePort::deviceIdentifierHeader();
    $deviceUuid = $request->header($header);

    if ($user = User::where("email", $deviceUuid)->exists()) {
      abort(409, "Guest account exists.");
    }

    DB::beginTransaction();

    try {
      $user = User::create([
        "email" => $deviceUuid,
        "password" => Hash::make($deviceUuid),
      ]);

      $user->profile()->create();

      $role = Role::guestRole();
      $user->roles()->attach($role);
      $user->preferences()->create();
    } catch (Exception $e) {
      DB::rollback();
      abort(500, $e->getMessage());
    }

    DB::commit();

    return [
      "message" => "Guest successfully created.",
    ];
  }
}
