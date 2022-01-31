<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Post;
use App\Models\PostType;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(PostType::class, function (Faker $faker) {
  $name = $faker->company;
  return [
    'type' => $name,
  ];
});

$factory->state(PostType::class, 'type_news', function (Faker $faker) {
  return [
    'type' => 'news',
  ];
});
