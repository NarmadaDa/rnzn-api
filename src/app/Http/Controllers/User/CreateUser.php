<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\CreateUserRequest;
use App\Models\User;
use App\Models\Role;
// use App\Models\Preferences;
use DB;
use Hash;
use Exception;

class CreateUser extends Controller
{
  /**
   * Handle the incoming request.
   *
   * @param  \App\Http\Requests\User\CreateUserRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function __invoke(CreateUserRequest $request)
  {
    $data = $request->validated();

    DB::beginTransaction();

    try {
      $user = User::create([
        "email" => strtolower($data["email"]),
        "password" => Hash::make($data["password"]),
      ]);

      $middle = isset($data["middle_name"]) ? $data["middle_name"] : "";
      // split middle-names varying formats, including hyphens
      $split = explode(" ", str_replace("-", " ", $middle));
      foreach ($split as $s) {
        $middle .= strtoupper(substr($s, 0, 1));
      }

      $user->profile()->create([
        "first_name" => ucfirst(strtolower($data["first_name"])),
        "middle_name" => $middle,
        "last_name" => ucfirst(strtolower($data["last_name"])),
      ]);

      $role = Role::where("slug", $data["role"])->first();
      $user->roles()->attach($role);

      $user->preferences()->create([]);

      $user->sendEmailVerificationNotification();
    } catch (Exception $e) {
      DB::rollback();
      abort(500, $e->getMessage());
    }

    DB::commit();

    return [
      "message" => "Account successfully created.",
    ];
  }
}
