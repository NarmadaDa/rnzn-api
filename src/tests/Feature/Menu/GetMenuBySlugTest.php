<?php

namespace Tests\Feature\Menu;

use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class GetMenuBySlugTest extends TestCase
{
  use RefreshDatabase;
  
  public function setUp(): void
  {
    parent::setUp();
    
    $this->setEndpoint('menus/invalid-slug');
    $this->setUserRole('guest');
  }

  /**
   * Test retrieval of Menu with no authentication.
   *
   * @return void
   */
  public function testGetMenuUnauthenticated()
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
   * Test retrieval of Menu with invalid slug.
   *
   * @return void
   */
  public function testGetMenuWithInvalidSlug()
  {
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
   * Test retrieval of Menu with valid authentication and details.
   *
   * @return void
   */
  public function testGetMenuWithAuth()
  {
    $menu = factory(Menu::class)->create();
    $this->setEndpoint('menus/'.$menu->slug);

    $response = $this->actingAs($this->user, 'api')
      ->getJson($this->getBaseURL());

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

  /**
   * Test retrieval of Menu with Menu Items.
   *
   * @return void
   */
  public function testGetMenuWithMenuItems()
  {
    $menuItem = factory(MenuItem::class)->state('item_type_article')->create();
    $this->setEndpoint('menus/'.$menuItem->menu->slug);

    $response = $this->actingAs($this->user, 'api')
      ->getJson($this->getBaseURL());

    $response->assertSuccessful()
      ->assertJson(['success' => true])
      ->assertJsonStructure([
        'success',
        'data' => [
          'menu' => [
            'uuid',
            'name',
            'slug',
            'menu_items' => [
              [
                'uuid',
                'sort_order',
                'title',
                'slug',
                'item_type',
              ]
            ]
          ],
        ],
      ]);
  }
}
