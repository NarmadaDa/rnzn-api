<?php

namespace App\Http\Middleware;

use Closure;

class Check2FAEnabled
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
    if (!$user) {
      abort(401, "Unauthorised.");
    }

    if (!$user->is2faReady()) {
      abort(403, "Unauthorised.");
    }

    return $next($request);
  }
}
