<?php

namespace Tests\Feature\Guest;

use App\HomePort;
use App\Models\Device;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Laravel\Passport\Client;
use Laravel\Passport\Passport;
use Tests\TestCase;

class GuestLoginTest extends TestCase
{
  use RefreshDatabase;
  
  public function setUp(): void
  {
    parent::setUp();
    
    $this->setBasePath('/');
    $this->setEndpoint('oauth/token');

    $this->setUserRole('guest');
  }

  /**
   * Test Guest login with no details.
   *
   * @return void
   */
  public function testGuestLoginWithNoDetails()
  {
    $response = $this->postJson($this->getBaseURL());

    $response->assertStatus(Response::HTTP_BAD_REQUEST)
      ->assertJson(['success' => false])
      ->assertJsonStructure([
        'success',
        'data' => [
          'message',
        ],
      ]);
  }

  /**
   * Test Guest login with valid details.
   *
   * @return void
   */
  // TODO: this test needs to be fixed
  // public function testGuestLoginWithValidDetails()
  // {
  //   $client = factory(Client::class)->state('password_client')->create();
  //   Passport::actingAsClient($client);

  //   $data = [
  //     'grant_type' => 'password',
  //     'client_id' => $client->id,
  //     'client_secret' => $client->getPlainSecretAttribute(),
  //     'username' => $this->user->email,
  //     'password' => $this->user->email,
  //   ];
  //   $headers = [
  //     'Content-Type' => 'multipart/form-data',
  //   ];

  //   $response = $this->withHeaders($headers)->post($this->getBaseURL(), $data);

  //   echo "data: \n";
  //   echo json_encode($this->user->load('roles'));
  //   echo json_encode($data);

  //   dd($response->getContent());

  //   $response->assertSuccessful()
  //     ->assertJson(['success' => true])
  //     ->assertJsonStructure([
  //       'success',
  //       'data' => [
  //         'access_token',
  //         'expires_in',
  //         'refresh_token',
  //         'token_type',
  //       ],
  //     ]);
  // }
}
