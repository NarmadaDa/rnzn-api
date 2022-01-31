<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\MenuItem;
use App\Models\QuickLink;
use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(QuickLink::class, function (Faker $faker) {
  $menuItem = factory(MenuItem::class)->state('item_type_article')->create();
  return [
    'menu_item_id'  => $menuItem->id,
    'sort_order'    => $faker->randomDigit,
    'user_id'       => factory(User::class)->create()->id,
    'uuid'          => $faker->uuid,
  ];
});

$factory->state(QuickLink::class, 'menu_item_type_article', function (Faker $faker) {
  $menuItem = factory(MenuItem::class)->state('item_type_article')->create();
  return [
    'menu_item_id' => $menuItem->id,
  ];
});
