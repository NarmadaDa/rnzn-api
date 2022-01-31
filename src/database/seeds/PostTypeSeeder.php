<?php

use App\Models\PostType;
use Illuminate\Database\Seeder;

class PostTypeSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $file = \File::get("database/data/post_types.json");
    $data = json_decode($file);

    foreach ($data as $o) {
      PostType::create([
        "type" => $o->type,
      ]);
    }
  }
}
