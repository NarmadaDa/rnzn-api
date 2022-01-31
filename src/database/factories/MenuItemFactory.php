<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Article;
use App\Models\Menu;
use App\Models\MenuItem;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(MenuItem::class, function (Faker $faker) {
  $name = $faker->company;
  return [
    'title'   => $name,
    'slug'    => Str::slug($name, '-'),
    'menu_id' => factory(Menu::class)->create()->id,
    'uuid'    => $faker->uuid,
  ];
});

$factory->state(MenuItem::class, 'item_type_article', function (Faker $faker) {
  return [
    'item_type' => 'article',
    'item_id'   => factory(Article::class)->create()->id,
  ];
});

$factory->state(MenuItem::class, 'item_type_menu', function (Faker $faker) {
  return [
    'item_type' => 'menu',
    'item_id'   => factory(Menu::class)->create()->id,
  ];
});
