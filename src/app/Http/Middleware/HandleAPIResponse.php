<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;

class HandleAPIResponse
{
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   * @param  string|null  $guard
   * @return mixed
   */
  public function handle($request, Closure $next, $guard = null)
  {
    $response = $next($request);

    if (isset($response->exception)) {
      $exception = $response->exception;

      $data = [
        "message" => $exception->getMessage(),
      ];

      if (isset($exception->validator)) {
        $data["validation_errors"] = $exception->validator->messages();
      }

      $response->header("Content-Type", "application/json");
      $response->setContent(
        json_encode([
          "success" => false,
          "data" => $data,
        ])
      );
    } else {
      $response->setContent(
        json_encode([
          "success" => true,
          "data" => $response->getOriginalContent(),
        ])
      );
    }

    return $response;
  }
}
