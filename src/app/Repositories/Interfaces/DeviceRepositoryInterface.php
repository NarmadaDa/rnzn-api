<?php

namespace App\Repositories\Interfaces;

use App\Models\Device;

/**
 * Interface DeviceRepositoryInterface
 * @package App\Repositories\Interfaces
 */
interface DeviceRepositoryInterface
{
  /**
   * @param string $uuid
   * @return void
   */
  public function deleteByUUID(string $uuid);

  /**
   * @param string $uuid
   * @return App\Models\Device
   */
  public function findByUUID(string $uuid): ?Device;
}
