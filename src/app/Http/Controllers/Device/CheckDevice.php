<?php

namespace App\Http\Controllers\Device;

use App\Http\Controllers\Device\BaseDeviceController;
use App\Http\Requests\Device\CheckDeviceRequest;
use Str;

class CheckDevice extends BaseDeviceController
{
  /**
   * Handle the incoming request.
   *
   * @param  \App\Http\Requests\Device\CheckDeviceRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function __invoke(CheckDeviceRequest $request)
  {
    $data = $request->validated();
    
    $device = $this->deviceRepository->findByUUID($data['uuid']);
    if (!$device) {
      abort(403, 'Invalid device identifier');
    }
    
    return [
      'valid' => true,
    ];
  }
}
