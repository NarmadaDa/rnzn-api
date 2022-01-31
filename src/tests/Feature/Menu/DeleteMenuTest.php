<?php

namespace Tests\Feature\Menu;

use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class DeleteMenuTest extends TestCase
{
  use RefreshDatabase;
  
  public function setUp(): void
  {
    parent::setUp();

    $this->setUserRole('admin');
  }

  /**
   * Test deletion of a Menu with no authentication.
   *
   * @return void
   */
  public function testDeleteMenuUnauthenticated()
  {
    $menu = factory(Menu::class)->create();

    $path = 'menus/'.$menu->uuid;
    $response = $this->deleteJson($this->getURL($path));

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
   * Test deletion of a Menu with no UUID.
   *
   * @return void
   */
  public function testDeleteMenuWithNoUuid()
  {
    $response = $this->actingAs($this->user, 'api')
      ->deleteJson($this->getURL('menus'));

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
   * Test deletion of a Menu with invalid UUID.
   *
   * @return void
   */
  public function testDeleteMenuWithInvalidUuid()
  {
    $response = $this->actingAs($this->user, 'api')
      ->deleteJson($this->getURL('menus/invalid-uuid'));

    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
      ->assertJson(['success' => false])
      ->assertJsonStructure([
        'success',
        'data' => [
          'validation_errors' => [
            'uuid',
          ],
        ],
      ]);
  }

  /**
   * Test deletion of a Menu with a non-existent UUID.
   *
   * @return void
   */
  public function testDeleteMenuWithNonExistentUuid()
  {
    $path = 'menus/'.$this->user->uuid;
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
   * Test deletion of a Menu with valid details.
   *
   * @return void
   */
  public function testDeleteMenuWithValidDetails()
  {
    $menu = factory(Menu::class)->create();

    $this->assertDatabaseHas('menus', $menu->toArray());

    $path = 'menus/'.$menu->uuid;
    $response = $this->actingAs($this->user, 'api')
      ->deleteJson($this->getURL($path));

    $response->assertSuccessful()
      ->assertJson(['success' => true])
      ->assertJsonStructure([
        'success',
        'data' => [
          'message',
        ],
      ]);

      $this->assertSoftDeleted('menus', $menu->toArray());
  }

  // TODO: fix related menu item tests below

  // /**
  //  * Test deletion of a Menu and related Menu Item.
  //  *
  //  * @return void
  //  */
  // public function testDeleteMenuWithMenuItemRelationship()
  // {
  //   $menuItem = factory(MenuItem::class)->state('item_type_menu')->create();
  //   $path = 'menus/'.$menuItem->item->uuid;

  //   $this->assertDatabaseHas('menus', $menuItem->item->toArray());
  //   $this->assertDatabaseHas('menu_items', $menuItem->toArray());

  //   $response = $this->actingAs($this->user, 'api')
  //     ->deleteJson($this->getURL($path));

  //   $response->dump();

  //   $response->assertSuccessful()
  //     ->assertJson(['success' => true])
  //     ->assertJsonStructure([
  //       'success',
  //       'data' => [
  //         'message',
  //       ],
  //     ]);

  //   $this->assertSoftDeleted('menus', $menuItem->item->toArray());
  //   $this->assertSoftDeleted('menu_items', $menuItem->toArray());
  // }
}
