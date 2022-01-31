<?php

namespace Tests\Feature\Device;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCaseWithoutDevice;

class AddDeviceTest extends TestCaseWithoutDevice
{
  use RefreshDatabase;
  
  public function setUp(): void
  {
    parent::setUp();

    $this->setEndpoint('devices');
  }

  /**
   * Test adding a Device with valid authentication.
   *
   * @return void
   */
  public function testAddDeviceWithValidDetails()
  {
    $response = $this->post($this->getBaseURL());

    $response->assertSuccessful()
      ->assertJson(['success' => true])
      ->assertJsonStructure([
        'success',
        'data' => [
          'device' => [
            'uuid',
          ],
        ],
      ]);
  }
  
}
