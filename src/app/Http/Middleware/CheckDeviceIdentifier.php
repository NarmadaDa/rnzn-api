<?php

namespace App\Http\Middleware;

use App\HomePort;
use App\Repositories\Interfaces\DeviceRepositoryInterface;
use Closure;

class CheckDeviceIdentifier
{
  /**
   * @var App\Repositories\Interfaces\DeviceRepositoryInterface
   */
  protected $deviceRepository;

  /**
   * CheckDeviceIdentifier constructor.
   * 
   * @param App\Repositories\Interfaces\DeviceRepositoryInterface $deviceRepository
   */
  public function __construct(DeviceRepositoryInterface $deviceRepository)
  {
    $this->deviceRepository = $deviceRepository;
  }

  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   * @return mixed
   */
  public function handle($request, Closure $next)
  {
    $header = HomePort::deviceIdentifierHeader();
    if (!$request->hasHeader($header))
    {
      abort(403, 'Invalid Device Identifier.');
    }

    $uuid = $request->header($header);
    try {
      if (!$this->deviceRepository->findByUUID($uuid))
      {
        abort(403, 'Invalid Device Identifier.');
      }
    } catch (\Exception $e) {
      abort(403, 'Invalid Device Identifier.');
    }

    return $next($request);
  }
}
