<?php

namespace Tests\Feature\Settings;

use Google2FA;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class Verify2FATest extends TestCase
{
  use RefreshDatabase;
  
  public function setUp(): void
  {
    parent::setUp();

    $this->setEndpoint('settings/2fa/verify');
    $this->setUserRole('admin');
  }

  /**
   * Test verification of 2FA with no authentication.
   *
   * @return void
   */
  public function testVerify2faUnauthenticated()
  {
    $response = $this->postJson($this->getBaseURL());

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
   * Test verification of 2FA with no details.
   *
   * @return void
   */
  public function testVerify2faWithNoDetails()
  {
    $response = $this->actingAs($this->user, 'api')
      ->postJson($this->getBaseURL());

    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
      ->assertJson(['success' => false])
      ->assertJsonStructure([
        'success',
        'data' => [
          'validation_errors' => [
            'google_2fa_otp',
          ],
        ],
      ]);
  }

  /**
   * Test verification of 2FA with invalid details.
   *
   * @return void
   */
  public function testVerify2faWithInvalidDetails()
  {
    $response = $this->actingAs($this->user, 'api')
      ->postJson($this->getBaseURL([
        'google_2fa_otp' => 123456789,
      ]));

    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
      ->assertJson(['success' => false])
      ->assertJsonStructure([
        'success',
        'data' => [
          'validation_errors' => [
            'google_2fa_otp',
          ],
        ],
      ]);
  }

  /**
   * Test verification of 2FA with valid details.
   *
   * @return void
   */
  public function testVerify2faWithValidDetails()
  {
    $secret = $this->user->google2FASecret();
    $otp = Google2FA::getCurrentOtp($this->user->google2FASecret());
    $data = [
      'google_2fa_otp' => $otp,
    ];
    $response = $this->actingAs($this->user, 'api')
      ->postJson($this->getBaseURL(), $data);

    $response->assertSuccessful()
      ->assertJson(['success' => true])
      ->assertJsonStructure([
        'success',
      ]);
  }
}
