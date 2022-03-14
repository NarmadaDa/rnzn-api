<?php

namespace App\Providers;

use App\Models\Article;
use App\Models\Media;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\Post;
use App\Models\SocialPost;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;
use URL;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   *
   * @return void
   */
  public function register()
  {
    //
  }

  /**
   * Bootstrap any application services.
   *
   * @return void
   */
  public function boot()
  {
    Schema::defaultStringLength(191);
    $url = config("app.url");
    URL::forceRootUrl($url);

    $scheme = str_contains($url, "http://") ? "http" : "https";
    URL::forceScheme($scheme);

    Passport::hashClientSecrets();

    Relation::morphMap([
      "article" => Article::class,
      "media" => Media::class,
      "menu" => Menu::class,
      "menu_item" => MenuItem::class,
      "news_post" => Post::class,
      "social_post" => SocialPost::class,
    ]);
  }
}
