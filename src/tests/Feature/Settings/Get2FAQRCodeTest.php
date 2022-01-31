<?php

namespace Tests\Feature\Settings;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class Get2FAQRCodeTest extends TestCase
{
  use RefreshDatabase;
  
  public function setUp(): void
  {
    parent::setUp();

    $this->setEndpoint('settings/2fa/qrcode');
    $this->setUserRole('admin');
  }

  /**
   * Test retrieval of a 2FA QR Code with no authentication.
   *
   * @return void
   */
  public function testGet2faQrCodeUnauthenticated()
  {
    $response = $this->get($this->getBaseURL());

    $response->assertStatus(Response::HTTP_UNAUTHORIZED)
      ->assertJson(['success' => false])
      ->assertJsonStructure([
        'success',
        'data' => [
          'message',
        ],
      ]);
  }

  /**
   * Test retrieval of a 2FA QR Code with valid authentication.
   *
   * @return void
   */
  public function testGet2faQrCodeWithValidAuthentication()
  {
    $response = $this->actingAs($this->user, 'api')
      ->get($this->getBaseURL());

    $response->assertSuccessful()
      ->assertJson(['success' => true])
      ->assertJsonStructure([
        'success',
        'data' => [
          'qrcode_url',
        ],
      ]);
  }
}
