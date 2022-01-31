<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
  /**
   * The policy mappings for the application.
   *
   * @var array
   */
  protected $policies = [
    // 'App\Model' => 'App\Policies\ModelPolicy',
  ];

  /**
   * Register any authentication / authorization services.
   *
   * @return void
   */
  public function boot()
  {
    $this->registerPolicies();

    // Passport::routes();
    Passport::tokensExpireIn(now()->addMinutes(30));
    Passport::refreshTokensExpireIn(now()->addDays(180));

    // Passport::tokensCan([
    //   "non-guest" => "Non-guest privileges.",
    //   "personnel" => "Personnel privileges.",
    //   "admin" => "Admin privileges.",
    //   "super-admin" => "Super Admin privileges.",
    // ]);

    // Passport::setDefaultScope(["non-guest"]);
  }
}
