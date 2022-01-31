<?php

namespace Tests\Feature\Menu;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class CreateMenuTest extends TestCase
{
  use RefreshDatabase;
  
  public function setUp(): void
  {
    parent::setUp();

    $this->setEndpoint('menus');
    $this->setUserRole('admin');
  }

  /**
   * Test creation of a Menu with no authentication.
   *
   * @return void
   */
  public function testCreateMenuUnauthenticated()
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
   * Test creation of a Menu with no details.
   *
   * @return void
   */
  public function testCreateMenuWithNoDetails()
  {
    $response = $this->actingAs($this->user, 'api')
      ->postJson($this->getBaseURL());

    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
      ->assertJson(['success' => false])
      ->assertJsonStructure([
        'success',
        'data' => [
          'validation_errors' => [
            'name',
            'slug',
          ],
        ],
      ]);
  }

  /**
   * Test creation of a Menu with invalid details.
   *
   * @return void
   */
  public function testCreateMenuWithInvalidDetails()
  {
    $response = $this->actingAs($this->user, 'api')
      ->postJson($this->getBaseURL(), [
        'name' => 123456789,
        'slug' => 'invalid slug',
      ]);

    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
      ->assertJson(['success' => false])
      ->assertJsonStructure([
        'success',
        'data' => [
          'validation_errors' => [
            'name',
            'slug',
          ],
        ],
      ]);
  }

  /**
   * Test creation of a Menu with valid details.
   *
   * @return void
   */
  public function testCreateMenuWithValidDetails()
  {
    $menu = [
      'name' => 'Test Menu',
      'slug' => 'test-menu',
    ];
    $response = $this->actingAs($this->user, 'api')
      ->postJson($this->getBaseURL(), $menu);

    $response->assertSuccessful()
      ->assertJson(['success' => true])
      ->assertJsonStructure([
        'success',
        'data' => [
          'menu' => [
            'uuid',
            'name',
            'slug',
          ],
        ],
      ]);

    $this->assertDatabaseHas('menus', $menu);
  }
}
