<?php

namespace App\Providers;

use App\Events\FBPageAuthorised;
use App\Events\FBFetchedPagePosts;
use App\Events\NewsPostCreated;
use App\Events\UUIDModelCreating;
use App\Listeners\CreateNotification;
use App\Listeners\FBFetchPagePosts;
use App\Listeners\GenerateModelUUID;
use App\Listeners\SendNewsPostNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
  /**
   * The event listener mappings for the application.
   *
   * @var array
   */
  protected $listen = [
    FBPageAuthorised::class => [FBFetchPagePosts::class],
    FBFetchedPagePosts::class => [FBFetchPagePosts::class],
    Registered::class => [SendEmailVerificationNotification::class],
    UUIDModelCreating::class => [GenerateModelUUID::class],
    NewsPostCreated::class => [
      CreateNotification::class,
      SendNewsPostNotification::class
    ],
  ];

  /**
   * Register any events for your application.
   *
   * @return void
   */
  public function boot()
  {
    parent::boot();
  }
}
