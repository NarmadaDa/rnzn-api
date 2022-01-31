<?php

namespace Tests\Feature\MenuItem;

use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class DeleteMenuItemTest extends TestCase
{
  use RefreshDatabase;

  private $menuItem;
  
  public function setUp(): void
  {
    parent::setUp();

    $this->menuItem = factory(MenuItem::class)
      ->state('item_type_article')->create();

    $path = 'menus/'.$this->menuItem->menu->uuid.'/items/'.$this->menuItem->uuid;
    $this->setEndpoint($path);
    $this->setUserRole('admin');
  }

  /**
   * Test deletion of a Menu Item with no authentication.
   *
   * @return void
   */
  public function testDeleteMenuItemUnauthenticated()
  {
    $response = $this->deleteJson($this->getBaseURL());

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
   * Test deletion of a Menu Item with invalid Menu UUID.
   *
   * @return void
   */
  public function testDeleteMenuItemWithInvalidDetails()
  {
    $response = $this->actingAs($this->user, 'api')
      ->deleteJson($this->getURL('menus/invalid-uuid/items/invalid-uuid'));

    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
      ->assertJson(['success' => false])
      ->assertJsonStructure([
        'success',
        'data' => [
          'validation_errors' => [
            'menu_uuid',
            'uuid',
          ],
        ],
      ]);
  }

  /**
   * Test deletion of a Menu Item with no UUID.
   *
   * @return void
   */
  public function testDeleteMenuItemWithNoUuid()
  {
    $path = 'menus/'.$this->menuItem->menu->uuid.'/items';
    $response = $this->actingAs($this->user, 'api')
      ->deleteJson($this->getURL($path));

    $response->assertStatus(Response::HTTP_METHOD_NOT_ALLOWED)
      ->assertJson(['success' => false])
      ->assertJsonStructure([
        'success',
        'data' => [
          'message',
        ],
      ]);
  }

  /**
   * Test deletion of a Menu Item with a non-existent UUID.
   *
   * @return void
   */
  public function testDeleteMenuWithNonExistentUuid()
  {
    $path = 'menus/'.$this->menuItem->menu->uuid.'/items/'.$this->user->uuid;
    $response = $this->actingAs($this->user, 'api')
      ->deleteJson($this->getURL($path));

    $response->assertStatus(Response::HTTP_NOT_FOUND)
      ->assertJson(['success' => false])
      ->assertJsonStructure([
        'success',
        'data' => [
          'message',
        ],
      ]);
  }

  /**
   * Test deletion of a Menu Item with valid details.
   *
   * @return void
   */
  public function testDeleteMenuItemWithValidDetails()
  {
    $response = $this->actingAs($this->user, 'api')
      ->deleteJson($this->getBaseURL());

    $response->assertSuccessful()
      ->assertJson(['success' => true])
      ->assertJsonStructure([
        'success',
        'data' => [
          'message',
        ],
      ]);
  }
}
