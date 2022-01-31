<?php

use App\Models\Post;
use App\Models\PostType;
use App\Models\Notification;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class PostSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $file = File::get("database/data/posts.json");
    $data = json_decode($file);

    $newsPostType = PostType::newsPostType();

    foreach ($data as $o) {
      $post = Post::create([
        "content" => $o->content,
        "title" => $o->title,
        "post_type_id" => $newsPostType->id,
      ]);

      $notification = Notification::create([
        "item_type" => "news_post",
        "item_id" => $post->id,
      ]);
    }
  }
}
