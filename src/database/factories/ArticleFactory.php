<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Article;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Article::class, function (Faker $faker) {
  $name = $faker->company;
  return [
    'title'   => $name,
    'slug'    => Str::slug($name, '-'),
    'content' => $faker->text,
    'uuid'    => $faker->uuid,
  ];
});
