<?php
use App\Models\Article;
use App\Models\ArticleRole;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\MenuItemRole;
use App\Models\MenuRole;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class ContentSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $file = File::get("database/data/content.json");
    $data = json_decode($file);

    $role = Role::personnelRole();

    foreach ($data as $o) {
      $this->createMenu($o, $role);
    }
  }

  private function createMenu($o, $role)
  {
    $menu = Menu::create([
      "name" => $o->name,
      "slug" => $o->slug,
    ]);

    MenuRole::create([
      "menu_id" => $menu->id,
      "role_id" => $role->id,
    ]);

    if (!empty($o->banner)) {
      $menu->media()->create([
        "type" => "banner",
        "url" => $o->banner,
        "thumbnail_url" => $o->banner,
      ]);
    }

    $i = 0;
    foreach ($o->menu_items as $mi) {
      $sort = $mi->sort_order ?? $i;

      // create actual item first
      $item = null;
      if ($mi->item_type === "article") {
        $item = $this->createArticle($mi->item, $role);
      } elseif ($mi->item_type === "menu") {
        $item = $this->createMenu($mi->item, $role);
      }

      $menuItem = MenuItem::create([
        "title" => $mi->title,
        "slug" => $mi->slug,
        "menu_id" => $menu->id,
        "item_type" => $mi->item_type,
        "item_id" => $item->id,
        "sort_order" => $sort,
      ]);

      MenuItemRole::create([
        "menu_item_id" => $menuItem->id,
        "role_id" => $role->id,
      ]);

      if (!empty($mi->banner)) {
        $menuItem->media()->create([
          "type" => "banner",
          "url" => $mi->banner,
          "thumbnail_url" => $mi->banner,
        ]);
      }

      if (!empty($mi->icon)) {
        $menuItem->media()->create([
          "type" => "icon",
          "url" => $mi->icon,
          "thumbnail_url" => $mi->icon,
        ]);
      }

      $i++;
    }

    return $menu;
  }

  private function createArticle($o, $role)
  {
    $keywords = $o->keywords ?? "";
    $item = Article::create([
      "title" => $o->title,
      "slug" => $o->slug,
      "content" => $o->content,
      "keywords" => $keywords,
    ]);

    ArticleRole::create([
      "article_id" => $item->id,
      "role_id" => $role->id,
    ]);

    if (!empty($o->banner)) {
      $item->media()->create([
        "type" => "banner",
        "url" => $o->banner,
        "thumbnail_url" => $o->banner,
      ]);
    }

    if (!empty($o->icon)) {
      $item->media()->create([
        "type" => "icon",
        "url" => $o->icon,
        "thumbnail_url" => $o->icon,
      ]);
    }

    return $item;
  }
}
