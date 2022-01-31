<?php

namespace Tests\Feature\MenuItem;

use App\Models\Article;
use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class UpdateMenuItemTest extends TestCase
{
  use RefreshDatabase;

  private $menuItem;
  
  public function setUp(): void
  {
    parent::setUp();

    $this->menuItem = factory(MenuItem::class)->state('item_type_article')->create();

    $path = 'menus/'.$this->menuItem->menu->uuid.'/items/'.$this->menuItem->uuid;
    $this->setEndpoint($path);
    $this->setUserRole('admin');
  }

  /**
   * Test update of a Menu Item with no authentication.
   *
   * @return void
   */
  public function testUpdateMenuItemUnauthenticated()
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
   * Test update of a Menu Item with no details.
   *
   * @return void
   */
  public function testUpdateMenuItemWithNoDetails()
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
   * Test update of a Menu Item with invalid UUID.
   *
   * @return void
   */
  public function testUpdateMenuItemWithInvalidMenuUuid()
  {
    $article = factory(Article::class)->create();
    $path = 'menus/'.$this->user->uuid.'/items/'.$this->menuItem->uuid;

    $response = $this->actingAs($this->user, 'api')
      ->postJson($this->getURL($path), [
        'title'       => 'Updated Test Article',
        'slug'        => 'updated-test-article',
        'sort_order'  => 0,
        'item_type'   => 'article',
        'item_uuid'   => $article->uuid,
      ]);

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
   * Test update of a Menu Item with invalid details.
   *
   * @return void
   */
  public function testUpdateMenuItemWithInvalidDetails()
  {
    $response = $this->actingAs($this->user, 'api')
      ->postJson($this->getBaseURL(), [
        'title'       => 123456789,
        'slug'        => 'invalid slug',
        'sort_order'  => -1,
        'item_type'   => 'invalid type',
        'item_uuid'   => 'invalid uuid',
      ]);

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
   * Test update of a Menu Item with a slug that already exists.
   *
   * @return void
   */
  public function testUpdateMenuItemWithWithExistingSlug()
  {
    $menuItem = factory(MenuItem::class)->state('item_type_article')->create();

    $response = $this->actingAs($this->user, 'api')
      ->postJson($this->getBaseURL(), [
        'title'       => 'Updated Test Article',
        'slug'        => $menuItem->slug,
        'sort_order'  => 0,
        'item_type'   => $this->menuItem->item_type,
        'item_uuid'   => $this->menuItem->item->uuid,
      ]);

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
   * Test update of a Menu Item (Article type) with valid details.
   *
   * @return void
   */
  public function testUpdateMenuItemWithValidArticleDetails()
  {
    $article = factory(Article::class)->create();

    $response = $this->actingAs($this->user, 'api')
      ->postJson($this->getBaseURL(), [
        'title'       => 'Updated Test Article',
        'slug'        => 'updated-test-article',
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
            'item_type',
            'sort_order',
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
   * Test update of a Menu Item (Menu type) with valid details.
   *
   * @return void
   */
  public function testUpdateMenuItemWithValidMenuDetails()
  {
    $menu = factory(Menu::class)->create();

    $response = $this->actingAs($this->user, 'api')
      ->postJson($this->getBaseURL(), [
        'title'       => 'Updated Test Menu',
        'slug'        => 'updated-test-menu',
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
            'item_type',
            'sort_order',
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
