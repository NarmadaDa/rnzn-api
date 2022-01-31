<?php

namespace App\Services;

use App\Models\PasswordReset;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Hash;
use Str;

class PasswordService
{
  /**
   * Initiate the password reset flow.
   *
   * @param  string  $email
   */
  public function initiatePasswordReset($email)
  {
    try {
      $user = User::where("email", $email)->first();
      if (!$user) {
        // return same response regardless if email exists
        return false;
      }

      // delete any existing password resets for this email
      PasswordReset::where("email", $user->email)->delete();

      $random1 = Str::random(4);
      $random2 = Str::random(4);
      $random3 = Str::random(4);
      $temp = strtoupper($random1 . $random2 . $random3);
      $expiry = Carbon::now()->addDays(7);
      $password = PasswordReset::create([
        "code" => Hash::make($temp),
        "email" => $user->email,
        "expires_at" => $expiry,
      ]);

      $user->sendResetPasswordNotification($temp);

      return true;
    }
    catch (Exception $e) {
      return false;
    }
  }

  /**
   * Change the user's password.
   *
   * @param  string   $email
   */
  public function changeUserPassword($email, $temporaryPassword, $newPassword)
  {
    try {
      $user = User::where("email", $email)->first();
      if (!$user) {
        return false;
      }

      // check temporary password
      $reset = PasswordReset::where("email", $user->email)
        ->where("expires_at", ">", Carbon::now())
        ->first();
      if (!$reset) {
        return false;
      }

      if (!Hash::check($temporaryPassword, $reset->code)) {
        return false;
      }

      $user->password = Hash::make($newPassword);
      $user->save();
      $reset->delete();

      $user->sendPasswordUpdatedNotification();

      return true;
    }
    catch (Exception $e) {
      return false;
    }
  }
}
