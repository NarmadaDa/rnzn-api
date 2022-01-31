<?php

namespace App\Http\Controllers\Device;

use App\Http\Controllers\Device\BaseDeviceController;
use App\Http\Requests\Device\AddDeviceRequest;
use Str;

class AddDevice extends BaseDeviceController
{
  /**
   * Handle the incoming request.
   *
   * @param  \App\Http\Requests\Device\AddDeviceRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function __invoke(AddDeviceRequest $request)
  {  
    $data = $request->validated();

    $uuid = (string)Str::uuid();
    $device = $this->deviceRepository->create([
      'uuid' => $uuid,
      'type' => $data['type'],
    ]);
    
    return [
      'device' => $device,
    ];
  }
}
