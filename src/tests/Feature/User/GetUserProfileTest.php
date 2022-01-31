<?php

namespace Tests\Feature\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class GetUserProfileTest extends TestCase
{
  use RefreshDatabase;
  
  public function setUp(): void
  {
    parent::setUp();

    $this->setEndpoint('users/me');
    $this->setUserRole('personnel');
  }

  /**
   * Test retrieval of current User's profile with no authentication.
   *
   * @return void
   */
  public function testGetUserProfileUnauthenticated()
  {
    $response = $this->getJson($this->getBaseURL());

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
   * Test retrieval of current User's profile with valid authentication.
   *
   * @return void
   */
  public function testGetUserProfileWithAuth()
  {
    $response = $this->actingAs($this->user, 'api')
      ->getJson($this->getBaseURL());

    $response->assertSuccessful()
      ->assertJson(['success' => true])
      ->assertJsonStructure([
        'success',
        'data' => [
          'user' => [
            'email',
            'email_verified_at',
            'uuid',
            'profile' => [
              'first_name',
              'middle_name',
              'last_name',
            ],
            'roles' => [],
          ],
        ],
      ]);
  }
}
