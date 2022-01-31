<?php

namespace App\Http\Middleware;

use Closure;

class VerifyNotGuest
{
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   * @return mixed
   */
  public function handle($request, Closure $next)
  {
    $user = $request->user();
    if (!$user || $user->isGuest() || !$user->isApproved()) {
      abort(401, "Unauthorised.");
    }

    return $next($request);
  }
}
