<?php

namespace Tests\Feature\Guest;

use App\HomePort;
use App\Models\Device;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCaseWithoutDevice;

class CreateGuestTest extends TestCaseWithoutDevice
{
  use RefreshDatabase;
  
  public function setUp(): void
  {
    parent::setUp();
    
    $this->setEndpoint('guests');
  }

  /**
   * Test creation of a Guest with no details.
   *
   * @return void
   */
  public function testCreateGuestWithNoDeviceIdentifier()
  {
    $response = $this->postJson($this->getBaseURL());

    $response->assertStatus(Response::HTTP_FORBIDDEN)
      ->assertJson(['success' => false])
      ->assertJsonStructure([
        'success',
        'data' => [
          'message',
        ],
      ]);
  }

  /**
   * Test creation of a Guest with a valid device identifier header.
   *
   * @return void
   */
  public function testCreateGuestWithValidDeviceIdentifierHeader()
  {
    $device = factory(Device::class)->create();
    $headers = [
      HomePort::deviceIdentifierHeader() => $device->uuid
    ];
    $response = $this->withHeaders($headers)->postJson($this->getBaseURL());

    $response->assertSuccessful()
      ->assertJson([
        'success' => true,
        'data' => [
          'message' => 'Guest successfully created.',
        ],
      ]);
  }
}
