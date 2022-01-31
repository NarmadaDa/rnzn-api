<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Profile;
use App\Models\Preferences;
use App\Models\Role;
use App\Models\User;
use Faker\Generator as Faker;
use PragmaRX\Google2FA\Google2FA;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
  return [
    'email' => $faker->unique()->safeEmail,
    'email_verified_at' => now(),
    'password' => \Hash::make('password'),
  ];
});

$factory->state(User::class, 'guest', function (Faker $faker) {
  $uuid = $faker->uuid;
  return [
    'email' => $uuid,
    'password' => $uuid,
  ];
});

$factory->define(Profile::class, function (Faker $faker) {
  return [
    'first_name' => $faker->firstName,
    'middle_name' => substr($faker->firstName, 0, 1),
    'last_name' => $faker->lastName,
  ];
});

$factory->define(Preferences::class, function (Faker $faker) {
  $google2fa = new Google2FA();
  return [
    'google_2fa_secret' => $google2fa->generateSecretKey(),
  ];
});

$factory->afterCreating(User::class, function ($user, $faker) {
  $user->profile()->save(factory(Profile::class)->make());
  $user->roles()->save(factory(Role::class)->state('guest')->make());
  $user->preferences()->save(factory(Preferences::class)->create([
    'user_id' => $user->id,
  ]));
});

$factory->afterCreatingState(User::class, 'guest', function ($user, $faker) {
  $user->profile()->save(factory(Profile::class)->make());
  $user->roles()->save(factory(Role::class)->state('guest')->make());
  $user->preferences()->save(factory(Preferences::class)->create([
    'user_id' => $user->id,
  ]));
});

$factory->afterCreatingState(User::class, 'family', function ($user, $faker) {
  $user->profile()->save(factory(Profile::class)->make());
  $user->roles()->save(factory(Role::class)->state('family')->make());
  $user->preferences()->save(factory(Preferences::class)->create([
    'user_id' => $user->id,
  ]));
});

$factory->afterCreatingState(User::class, 'personnel', function ($user, $faker) {
  $user->profile()->save(factory(Profile::class)->make());
  $user->roles()->save(factory(Role::class)->state('personnel')->make());
  $user->preferences()->save(factory(Preferences::class)->create([
    'user_id' => $user->id,
  ]));
});

$factory->afterCreatingState(User::class, 'admin', function ($user, $faker) {
  $user->profile()->save(factory(Profile::class)->make());
  $user->roles()->save(factory(Role::class)->state('admin')->make());
  $user->preferences()->save(factory(Preferences::class)->create([
    'user_id' => $user->id,
  ]));
});

$factory->afterCreatingState(User::class, 'super', function ($user, $faker) {
  $user->profile()->save(factory(Profile::class)->make());
  $user->roles()->save(factory(Role::class)->state('super')->make());
  $user->preferences()->save(factory(Preferences::class)->create([
    'user_id' => $user->id,
  ]));
});
