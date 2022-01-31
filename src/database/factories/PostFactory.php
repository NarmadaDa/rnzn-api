<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Post;
use App\Models\PostType;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Post::class, function (Faker $faker) {
  $name = $faker->company;
  return [
    'title'   => $name,
    'content' => $faker->text,
    'uuid'    => $faker->uuid,
  ];
});

$factory->state(Post::class, 'type_news', function (Faker $faker) {
  return [
    'post_type_id' => factory(PostType::class)->state('type_news')->create()->id,
  ];
});
