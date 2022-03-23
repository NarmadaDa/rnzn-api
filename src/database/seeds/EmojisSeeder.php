<?php

use Illuminate\Database\Seeder;

class EmojisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $file = File::get("database/data/emojis.json");
        $data = json_decode($file);

        foreach ($data as $o) {
            DB::table('emojis')->insert([
            "emoji" => $o->emoji,
            ]);
          }
    }
}
