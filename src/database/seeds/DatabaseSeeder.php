<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   *
   * @return void
   */
  public function run()
  {
    // required default data
    $this->call(RoleSeeder::class);
    $this->call(PostTypeSeeder::class);
    $this->call(PostSeeder::class);

    // temporary testing data
    $this->call(ContentSeeder::class);
    $this->call(GuestContentSeeder::class);
    $this->call(UserSeeder::class);
    // $this->call(SocialSeeder::class);
  }
}
