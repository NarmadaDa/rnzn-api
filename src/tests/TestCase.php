<?php

namespace Tests;

use HomePort;
use App\Models\Device;
use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\WithFaker;

abstract class TestCase extends BaseTestCase
{
  use CreatesApplication;

  protected $basepath;
  protected $device;
  protected $endpoint;
  protected $user;

  public function __construct()
  {
    parent::__construct();
    $this->basepath = '/api/v1/';
  }
  
  public function setUp(): void
  {
    parent::setUp();

    $this->device = factory(Device::class)->create();
    $this->withHeaders([
      HomePort::deviceIdentifierHeader() => $this->device->uuid,
    ]);
  }

  protected function getBaseURL(): string
  {
    return $this->basepath.$this->endpoint;
  }

  protected function getURL($path): string
  {
    return $this->basepath.$path;
  }

  protected function setBasePath(string $basepath)
  {
    $this->basepath = $basepath;
  }

  protected function setEndpoint(string $endpoint)
  {
    $this->endpoint = $endpoint;
  }

  protected function setUserRole($role)
  {
    $this->user = factory(User::class)->state($role)->create();
  }
}
