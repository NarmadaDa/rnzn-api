<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Role;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Role::class, function (Faker $faker) {
  $name = $faker->company;
  return [
    'name' => $name,
    'slug' => Str::slug($name, '-'),
  ];
});

$factory->state(Role::class, 'guest', function (Faker $faker) {
  return [
    'name' => 'Guest',
    'slug' => 'guest',
  ];
});

$factory->state(Role::class, 'family', function (Faker $faker) {
  return [
    'name' => 'Family',
    'slug' => 'family',
  ];
});

$factory->state(Role::class, 'personnel', function (Faker $faker) {
  return [
    'name' => 'Personnel',
    'slug' => 'personnel',
  ];
});

$factory->state(Role::class, 'admin', function (Faker $faker) {
  return [
    'name' => 'Admin',
    'slug' => 'admin',
  ];
});

$factory->state(Role::class, 'super', function (Faker $faker) {
  return [
    'name' => 'Super Admin',
    'slug' => 'super',
  ];
});
