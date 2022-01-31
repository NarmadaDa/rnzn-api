<?php

namespace Tests\Feature\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class CreateUserTest extends TestCase
{
  use RefreshDatabase;
  
  public function setUp(): void
  {
    parent::setUp();
    
    $this->setEndpoint('users');
  }

  /**
   * Test creation of a User with no details.
   *
   * @return void
   */
  public function testCreateUserWithNoDetails()
  {
    $response = $this->postJson($this->getBaseURL());

    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
      ->assertJson(['success' => false])
      ->assertJsonStructure([
        'success',
        'data' => [
          'message',
          'validation_errors' => [
            'email' => [],
            'first_name' => [],
            'last_name' => [],
            'middle_name' => [],
            'password' => [],
            'role' => [],
          ],
        ],
      ]);
  }

  /**
   * Test creation of a User with invalid details.
   *
   * @return void
   */
  public function testCreateUserWithInvalidDetails()
  {
    $response = $this->postJson($this->getBaseURL(), [
      'email'       => 'invalid@email',
      'password'    => '2short',
      'first_name'  => 123,
      'middle_name' => 456,
      'last_name'   => 789,
      'role'        => 'invalid',
    ]);

    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
      ->assertJson(['success' => false])
      ->assertJsonStructure([
        'success',
        'data' => [
          'message',
          'validation_errors' => [
            'email' => [],
            'first_name' => [],
            'last_name' => [],
            'middle_name' => [],
            'password' => [],
            'role' => [],
          ],
        ],
      ]);
  }

  /**
   * Test creation of a User with valid details.
   *
   * @return void
   */
  public function testCreateUserWithValidDetails()
  {
    $response = $this->postJson($this->getBaseURL(), [
      'email'       => 'johndoe@email.com',
      'password'    => 'password',
      'first_name'  => 'John',
      'middle_name' => 'F',
      'last_name'   => 'Doe',
      'role'        => 'personnel',
    ]);

    $response->assertSuccessful()
      ->assertJson([
        'success' => true,
        'data' => [
          'message' => 'Account successfully created.',
        ],
      ]);
  }
}
