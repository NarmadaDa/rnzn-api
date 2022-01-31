<?php

namespace Tests\Feature\MenuItem;

use App\Models\Article;
use App\Models\Menu;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class CreateMenuItemTest extends TestCase
{
  use RefreshDatabase;

  private $menu;
  
  public function setUp(): void
  {
    parent::setUp();

    $this->menu = factory(Menu::class)->create();

    $this->setEndpoint('menus/'.$this->menu->uuid.'/items');
    $this->setUserRole('admin');
  }

  /**
   * Test creation of a Menu Item with no authentication.
   *
   * @return void
   */
  public function testCreateMenuItemUnauthenticated()
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
   * Test creation of a Menu Item with no details.
   *
   * @return void
   */
  public function testCreateMenuItemWithNoDetails()
  {
    $response = $this->actingAs($this->user, 'api')
      ->postJson($this->getBaseURL());

    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
      ->assertJson(['success' => false])
      ->assertJsonStructure([
        'success',
        'data' => [
          'validation_errors' => [
            'title',
            'slug',
            'sort_order',
            'item_type',
            'item_uuid',
          ],
        ],
      ]);
  }

  /**
   * Test creation of a Menu Item with invalid details.
   *
   * @return void
   */
  public function testCreateMenuItemWithInvalidDetails()
  {
    $response = $this->actingAs($this->user, 'api')
      ->postJson($this->getBaseURL([
        'title'       => 123456789,
        'slug'        => 'invalid slug',
        'sort_order'  => -1,
        'item_type'   => 'invalid type',
        'item_uuid'   => 'invalid uuid',
      ]));

    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
      ->assertJson(['success' => false])
      ->assertJsonStructure([
        'success',
        'data' => [
          'validation_errors' => [
            'title',
            'slug',
            'sort_order',
            'item_type',
            'item_uuid',
          ],
        ],
      ]);
  }

  /**
   * Test creation of a Menu Item with Item UUID matching the Menu UUID.
   *
   * @return void
   */
  public function testCreateMenuItemWithSameMenuUuid()
  {
    $response = $this->actingAs($this->user, 'api')
      ->postJson($this->getBaseURL(), [
        'title'       => 'Test Menu Item',
        'slug'        => 'test-menu-item',
        'sort_order'  => 0,
        'item_type'   => 'menu',
        'item_uuid'   => $this->menu->uuid,
      ]);

    $response->assertStatus(Response::HTTP_BAD_REQUEST)
      ->assertJson(['success' => false])
      ->assertJsonStructure([
        'success',
        'data' => [
          'message',
        ],
      ]);
  }

  // TODO: create a test (and add required code in the route)
  // to prevent adding the same menu to itself (infinite loop)

  /**
   * Test creation of a Menu Item (Article type) with valid details.
   *
   * @return void
   */
  public function testCreateMenuItemWithValidArticleDetails()
  {
    $article = factory(Article::class)->create();

    $response = $this->actingAs($this->user, 'api')
      ->postJson($this->getBaseURL(), [
        'title'       => 'Test Menu Item',
        'slug'        => 'test-menu-item',
        'sort_order'  => 0,
        'item_type'   => 'article',
        'item_uuid'   => $article->uuid,
      ]);

    $response->assertSuccessful()
      ->assertJson(['success' => true])
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
   * Test creation of a Menu Item (Menu type) with valid details.
   *
   * @return void
   */
  public function testCreateMenuItemWithValidMenuDetails()
  {
    $menu = factory(Menu::class)->create();

    $response = $this->actingAs($this->user, 'api')
      ->postJson($this->getBaseURL(), [
        'title'       => 'Test Menu Item',
        'slug'        => 'test-menu-item',
        'sort_order'  => 0,
        'item_type'   => 'menu',
        'item_uuid'   => $menu->uuid,
      ]);

    $response->assertSuccessful()
      ->assertJson(['success' => true])
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
