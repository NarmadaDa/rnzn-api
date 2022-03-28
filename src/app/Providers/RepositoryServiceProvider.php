<?php

namespace App\Providers;

use App\Repositories\BaseRepository;
use App\Repositories\Eloquent\ArticleRepository;
use App\Repositories\Eloquent\DeviceRepository;
use App\Repositories\Eloquent\MenuItemRepository;
use App\Repositories\Eloquent\MenuRepository;
use App\Repositories\Eloquent\PostRepository;
use App\Repositories\Eloquent\PostTypeRepository;
use App\Repositories\Eloquent\QuickLinkRepository;
use App\Repositories\Eloquent\RoleRepository;
use App\Repositories\Eloquent\UserRepository;
use App\Repositories\Eloquent\ChannelRepository;
use App\Repositories\Eloquent\ForumpostRepository;
use App\Repositories\Eloquent\ConditionsRepository;
use App\Repositories\Eloquent\InappropriateRepository;
use App\Repositories\Eloquent\PinPostRepository;
use App\Repositories\Eloquent\CommentRepository;
use App\Repositories\Eloquent\ForumpostreactionRepository;
use App\Repositories\Interfaces\ArticleRepositoryInterface;
use App\Repositories\Interfaces\DeviceRepositoryInterface;
use App\Repositories\Interfaces\EloquentRepositoryInterface;
use App\Repositories\Interfaces\MenuItemRepositoryInterface;
use App\Repositories\Interfaces\MenuRepositoryInterface;
use App\Repositories\Interfaces\PostRepositoryInterface;
use App\Repositories\Interfaces\PostTypeRepositoryInterface;
use App\Repositories\Interfaces\QuickLinkRepositoryInterface;
use App\Repositories\Interfaces\RoleRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Interfaces\ChannelRepositoryInterface;
use App\Repositories\Interfaces\ForumpostRepositoryInterface;
use App\Repositories\Interfaces\ConditionsRepositoryInterface;
use App\Repositories\Interfaces\InappropriateRepositoryInterface;
use App\Repositories\Interfaces\PinPostRepositoryInterface;
use App\Repositories\Interfaces\CommentRepositoryInterface;
use App\Repositories\Interfaces\ForumpostreactionRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
  /**
   * Register services.
   *
   * @return void
   */
  public function register()
  {
    $this->app->bind(
      EloquentRepositoryInterface::class,
      BaseRepository::class
    );

    $this->app->bind(
      ArticleRepositoryInterface::class,
      ArticleRepository::class
    );

    $this->app->bind(
      DeviceRepositoryInterface::class,
      DeviceRepository::class
    );

    $this->app->bind(
      MenuItemRepositoryInterface::class,
      MenuItemRepository::class
    );

    $this->app->bind(
      MenuRepositoryInterface::class,
      MenuRepository::class
    );

    $this->app->bind(
      PostRepositoryInterface::class,
      PostRepository::class
    );

    $this->app->bind(
      PostTypeRepositoryInterface::class,
      PostTypeRepository::class
    );

    $this->app->bind(
      QuickLinkRepositoryInterface::class,
      QuickLinkRepository::class
    );

    $this->app->bind(
      RoleRepositoryInterface::class,
      RoleRepository::class
    );

    $this->app->bind(
      UserRepositoryInterface::class,
      UserRepository::class
    );

    $this->app->bind(
      ChannelRepositoryInterface::class,
      ChannelRepository::class
    );

    $this->app->bind(
      ConditionsRepositoryInterface::class,
      ConditionsRepository::class
    );

    $this->app->bind(
      ForumpostRepositoryInterface::class,
      ForumpostRepository::class
    );

    $this->app->bind(
      InappropriateRepositoryInterface::class,
      InappropriateRepository::class
    );

    $this->app->bind(
      CommentRepositoryInterface::class,
      CommentRepository::class
    );

    $this->app->bind(
      ForumpostreactionRepositoryInterface::class,
      ForumpostreactionRepository::class
    );

    $this->app->bind(
      PinPostRepositoryInterface::class,
      PinPostRepository::class
    );

  }
}
