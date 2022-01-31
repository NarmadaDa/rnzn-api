<?php

namespace Tests\Feature\Menu;

use App\Models\Menu;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class UpdateMenuTest extends TestCase
{
  use RefreshDatabase;

  private $menu;
  
  public function setUp(): void
  {
    parent::setUp();

    $this->menu = factory(Menu::class)->create();

    $path = 'menus/'.$this->menu->uuid;
    $this->setEndpoint($path);
    $this->setUserRole('admin');
  }

  /**
   * Test update of a Menu with no authentication.
   *
   * @return void
   */
  public function testUpdateMenuUnauthenticated()
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
   * Test update of a Menu with no details.
   *
   * @return void
   */
  public function testUpdateMenuWithNoDetails()
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
   * Test update of a Menu with invalid details.
   *
   * @return void
   */
  public function testUpdateMenuWithInvalidDetails()
  {
    $response = $this->actingAs($this->user, 'api')
      ->postJson($this->getBaseURL([
        'name' => 123456789,
        'slug' => 'invalid slug',
      ]));

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
   * Test update of a Menu with a slug that already exists.
   *
   * @return void
   */
  public function testUpdateMenuWithWithExistingSlug()
  {
    $menu = factory(Menu::class)->create();

    $response = $this->actingAs($this->user, 'api')
      ->postJson($this->getBaseURL([
        'name' => $menu->name,
        'slug' => $menu->slug,
      ]));

    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
      ->assertJson(['success' => false])
      ->assertJsonStructure([
        'success',
        'data' => [
          'validation_errors' => [
            'slug',
          ],
        ],
      ]);
  }

  /**
   * Test update of a Menu with valid details.
   *
   * @return void
   */
  public function testUpdateMenuWithValidDetails()
  {
    $response = $this->actingAs($this->user, 'api')
      ->postJson($this->getBaseURL(), [
        'name' => 'Updated Test Menu',
        'slug' => 'updated-test-menu',
      ]);

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
  }
}
