<?php

namespace App\Repositories\Eloquent;

use App\Models\Device;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\DeviceRepositoryInterface;

/**
 * Class DeviceRepository
 * @package App\Repositories\Eloquent
 */
class DeviceRepository extends BaseRepository implements DeviceRepositoryInterface
{
  /**
   * DeviceRepository constructor.
   * 
   * @param App\Models\Device $model
   */
  public function __construct(Device $model)
  {
    parent::__construct($model);
  }

  /**
   * @param string $uuid
   * @return void
   */
  public function deleteByUUID(string $uuid)
  {
    return $this->model->where('uuid', $uuid)->delete();
  }

  /**
   * @param string $uuid
   * @return App\Models\Device
   */
  public function findByUUID(string $uuid): ?Device
  {
    return $this->model->where('uuid', $uuid)->first();
  }
}
