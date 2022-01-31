<?php

namespace App\Http\Controllers\Device;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\DeviceRepositoryInterface;

class BaseDeviceController extends Controller
{
  /**
   * @var App\Repositories\Interfaces\DeviceRepositoryInterface
   */
  protected $deviceRepository;

  /**
   * BaseDeviceController constructor.
   * 
   * @param App\Repositories\Interfaces\DeviceRepositoryInterface $device
   */
  public function __construct(DeviceRepositoryInterface $deviceRepository)
  {
    $this->deviceRepository = $deviceRepository;
  }
}
