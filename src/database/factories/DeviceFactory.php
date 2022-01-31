<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Device;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Device::class, function (Faker $faker) {
  return [
    'uuid' => $faker->uuid,
  ];
});
