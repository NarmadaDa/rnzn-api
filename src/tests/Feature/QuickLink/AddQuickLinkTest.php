<?php

namespace Tests\Feature\QuickLink;

use App\Models\MenuItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class AddQuickLinkTest extends TestCase
{
  use RefreshDatabase;
  
  public function setUp(): void
  {
    parent::setUp();

    $this->setEndpoint('quicklinks');
    $this->setUserRole('personnel');
  }

  /**
   * Test adding a Quick Link with no authentication.
   *
   * @return void
   */
  public function testAddQuickLinkUnauthenticated()
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
   * Test adding a Quick Link with no details.
   *
   * @return void
   */
  public function testAddQuickLinkWithNoDetails()
  {
    $response = $this->actingAs($this->user, 'api')
      ->postJson($this->getBaseURL());

    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
      ->assertJson(['success' => false])
      ->assertJsonStructure([
        'success',
        'data' => [
          'validation_errors' => [
            'menu_item_uuid',
            'sort_order',
          ],
        ],
      ]);
  }

  /**
   * Test adding a Quick Link with non-existent Menu Item UUID.
   *
   * @return void
   */
  public function testAddQuickLinkWithNonExistentMenuItemUuid()
  {
    $response = $this->actingAs($this->user, 'api')
      ->postJson($this->getBaseURL(), [
        'menu_item_uuid'  => $this->user->uuid,
        'sort_order'      => 0,
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
   * Test adding a Quick Link with invalid details.
   *
   * @return void
   */
  public function testAddQuickLinkWithInvalidDetails()
  {
    $response = $this->actingAs($this->user, 'api')
      ->postJson($this->getBaseURL(), [
        'menu_item_uuid'  => 'invalid uuid',
        'sort_order'      => 'invalid sort order',
      ]);

    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
      ->assertJson(['success' => false])
      ->assertJsonStructure([
        'success',
        'data' => [
          'validation_errors' => [
            'menu_item_uuid',
            'sort_order',
          ],
        ],
      ]);
  }

  /**
   * Test creation of a Quick Link with valid details.
   *
   * @return void
   */
  public function testAddQuickLinkWithValidDetails()
  {
    $menuItem = factory(MenuItem::class)->state('item_type_article')->create();
    $quickLink = [
      'menu_item_uuid'  => $menuItem->uuid,
      'sort_order'      => 0,
    ];
    $response = $this->actingAs($this->user, 'api')
      ->postJson($this->getBaseURL(), $quickLink);

    $response->assertSuccessful()
      ->assertJson(['success' => true])
      ->assertJsonStructure([
        'success',
        'data' => [
          'quick_link' => [
            'uuid',
            'sort_order',
            'menu_item' => [
              'uuid',
              'title',
              'slug',
              'item_type',
              'sort_order',
            ],
          ],
        ],
      ]);
  }

  // TODO: add tests as admin/super that should fail

}
