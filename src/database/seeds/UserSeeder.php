<?php

use App\Models\Profile;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use PragmaRX\Google2FA\Google2FA;

class UserSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $file = \File::get("database/data/users.json");
    $data = json_decode($file);
    $google2fa = new Google2FA();

    foreach ($data as $o) {
      $user = User::create([
        "email" => $o->email_address,
        "password" => \Hash::make($o->password),
        "approved_at" => \Carbon\Carbon::now(),
      ]);

      $user->profile()->create([
        "first_name" => $o->first_name,
        "middle_name" => substr($o->middle_name, 0, 1),
        "last_name" => $o->last_name,
      ]);

      $user->preferences()->create();

      foreach ($o->roles as $slug) {
        $role = Role::where("slug", $slug)->first();
        $user->roles()->attach($role);
      }
    }
  }
}
