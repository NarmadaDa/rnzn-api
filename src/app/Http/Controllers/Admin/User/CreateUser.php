<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateUserRequest;
use App\Models\PasswordReset;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use DB;
use Hash;
use Str;

class CreateUser extends Controller
{
  /**
   * Handle the incoming request.
   *
   * @param  \App\Http\Requests\Admin\CreateUserRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function __invoke(CreateUserRequest $request)
  {
    $data = $request->validated();
    $user = $request->user();

    DB::beginTransaction();

    try {
      $random = Str::random(50);

      $user = User::create([
        "approved_at" => Carbon::now(),
        "approved_by" => $user->id,
        "email" => strtolower($data["email"]),
        "password" => Hash::make($random),
      ]);

      $middle = "";
      // split middle-names varying formats, including hyphens
      $split = explode(" ", str_replace("-", " ", $data["middle_name"]));
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

      // delete any existing password resets for this email
      PasswordReset::where("email", $data["email"])->delete();

      $random1 = Str::random(4);
      $random2 = Str::random(4);
      $random3 = Str::random(4);
      $temp = $random1 . $random2 . $random3;
      $expiry = Carbon::now()->addDays(7);
      $password = PasswordReset::create([
        "code" => Hash::make($temp),
        "email" => $data["email"],
        "expires_at" => $expiry,
      ]);
      $user->sendResetPasswordNotification($temp);
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
