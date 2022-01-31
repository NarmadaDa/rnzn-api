<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use League\OAuth2\Server\Exception\OAuthServerException;
use Throwable;

class Handler extends ExceptionHandler
{
  /**
   * A list of the exception types that are not reported.
   *
   * @var array
   */
  protected $dontReport = [];

  /**
   * A list of the inputs that are never flashed for validation exceptions.
   *
   * @var array
   */
  protected $dontFlash = ["password", "password_confirmation"];

  /**
   * Report or log an exception.
   *
   * @param  \Throwable  $exception
   * @return void
   *
   * @throws \Exception
   */
  public function report(Throwable $exception)
  {
    // prevent logging of expired tokens error
    if ($exception instanceof OAuthServerException && $exception->getCode() == 9) {
      return;
    }
  
    parent::report($exception);
  }

  /**
   * Render an exception into an HTTP response.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Throwable  $exception
   * @return \Symfony\Component\HttpFoundation\Response
   *
   * @throws \Throwable
   */
  public function render($request, Throwable $exception)
  {
    $statusCode = 500;
    if (method_exists($exception, "getStatusCode")) {
      $statusCode = $exception->getStatusCode();
    } elseif (method_exists($exception, "statusCode")) {
      $statusCode = $exception->statusCode();
    } elseif (isset($exception->status)) {
      $statusCode = $exception->status;
    }

    $response = response()->json(
      [
        "success" => false,
        "data" => [
          "message" => $exception->getMessage(),
        ],
      ],
      $statusCode
    );

    if (!str_contains($request->getPathInfo(), "/api/v1")) {
      return parent::render($request, $exception);
    }

    return $response;
  }
}
