<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Menu;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Menu::class, function (Faker $faker) {
  $name = $faker->company;
  return [
    'name' => $name,
    'slug' => Str::slug($name, '-'),
    'uuid' => $faker->uuid,
  ];
});
