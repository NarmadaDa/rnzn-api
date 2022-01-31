<?php

namespace Tests\Feature\QuickLink;

use App\Models\MenuItem;
use App\Models\QuickLink;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class RemoveQuickLinkTest extends TestCase
{
  use RefreshDatabase;
  
  public function setUp(): void
  {
    parent::setUp();

    $this->setUserRole('personnel');
  }

  /**
   * Test removal of a Quick Link with no authentication.
   *
   * @return void
   */
  public function testRemoveQuickLinkUnauthenticated()
  {
    $quickLink = factory(QuickLink::class)->state('menu_item_type_article')->create();

    $path = 'quicklinks/'.$quickLink->uuid;
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
   * Test removal of a Quick Link with no UUID.
   *
   * @return void
   */
  public function testRemoveQuickLinkWithNoUuid()
  {
    $response = $this->actingAs($this->user, 'api')
      ->deleteJson($this->getURL('quicklinks'));

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
   * Test removal of a Quick Link with invalid UUID.
   *
   * @return void
   */
  public function testRemoveQuickLinkWithInvalidUuid()
  {
    $response = $this->actingAs($this->user, 'api')
      ->deleteJson($this->getURL('quicklinks/invalid-uuid'));

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
   * Test deletion of a Quick Link with a non-existent UUID.
   *
   * @return void
   */
  public function testRemoveQuickLinkWithNonExistentUuid()
  {
    $path = 'quicklinks/'.$this->user->uuid;
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
   * Test deletion of a Quick Link with valid details.
   *
   * @return void
   */
  public function testRemoveQuickLinkWithValidDetails()
  {
    $quickLink = factory(QuickLink::class)->state('menu_item_type_article')->create();

    $path = 'quicklinks/'.$quickLink->uuid;
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
  }
}
