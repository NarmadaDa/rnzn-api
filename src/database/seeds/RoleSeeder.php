<?php

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $file = \File::get("database/data/roles.json");
    $data = json_decode($file);

    foreach ($data as $o) {
      Role::create([
        "name" => $o->name,
        "slug" => $o->slug,
      ]);
    }
  }
}
