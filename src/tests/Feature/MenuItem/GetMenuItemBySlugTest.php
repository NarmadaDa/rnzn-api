<?php

namespace Tests\Feature\MenuItem;

use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class GetMenuItemBySlugTest extends TestCase
{
  use RefreshDatabase;
  
  public function setUp(): void
  {
    parent::setUp();
    
    $this->setEndpoint('menus/invalid-uuid/items/invalid-slug');
    $this->setUserRole('guest');
  }

  /**
   * Test retrieval of Menu Item with no authentication.
   *
   * @return void
   */
  public function testGetMenuItemUnauthenticated()
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
   * Test retrieval of Menu Item with invalid Menu UUID.
   *
   * @return void
   */
  public function testGetMenuItemWithInvalidMenuUuid()
  {
    $this->setEndpoint('menus/'.$this->user->uuid.'/items/invalid-slug');

    $response = $this->actingAs($this->user, 'api')
      ->getJson($this->getBaseURL());

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
   * Test retrieval of Menu Item with invalid slug.
   *
   * @return void
   */
  public function testGetMenuItemWithInvalidSlug()
  {
    $menu = factory(Menu::class)->create();
    $this->setEndpoint('menus/'.$menu->uuid.'/items/invalid-slug');

    $response = $this->actingAs($this->user, 'api')
      ->getJson($this->getBaseURL());

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
   * Test retrieval of Menu Item with valid authentication and article type.
   *
   * @return void
   */
  public function testGetMenuItemWithValidArticleType()
  {
    $menuItem = factory(MenuItem::class)->state('item_type_article')->create();
    $this->setEndpoint('menus/'.$menuItem->menu->uuid.'/items/'.$menuItem->slug);

    $response = $this->actingAs($this->user, 'api')
      ->getJson($this->getBaseURL());

    $response->assertSuccessful()
      ->assertJson([
        'success' => true,
        'data' => [
          'menu_item' => [
            'item_type' => 'article',
          ],
        ],
      ])
      ->assertJsonStructure([
        'success',
        'data' => [
          'menu_item' => [
            'uuid',
            'title',
            'slug',
            'sort_order',
            'item_type',
            'item' => [
              'uuid',
              'title',
              'slug',
              'content',
            ],
          ],
        ],
      ]);
  }

  /**
   * Test retrieval of Menu Item with valid authentication and menu type.
   *
   * @return void
   */
  public function testGetMenuItemWithValidMenuType()
  {
    $menuItem = factory(MenuItem::class)->state('item_type_menu')->create();
    $this->setEndpoint('menus/'.$menuItem->menu->uuid.'/items/'.$menuItem->slug);

    $response = $this->actingAs($this->user, 'api')
      ->getJson($this->getBaseURL());

    $response->assertSuccessful()
      ->assertJson([
        'success' => true,
        'data' => [
          'menu_item' => [
            'item_type' => 'menu',
          ],
        ],
      ])
      ->assertJsonStructure([
        'success',
        'data' => [
          'menu_item' => [
            'uuid',
            'title',
            'slug',
            'sort_order',
            'item_type',
            'item' => [
              'uuid',
              'name',
              'slug',
            ],
          ],
        ],
      ]);
  }
}
