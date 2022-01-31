<?php

namespace Tests\Feature\QuickLink;

use App\Models\QuickLink;
use App\Models\MenuItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class GetQuickLinksTest extends TestCase
{
  use RefreshDatabase;
  
  public function setUp(): void
  {
    parent::setUp();

    $this->setUserRole('personnel');
    $this->setEndpoint('quicklinks');

    $quickLinks = factory(QuickLink::class, 2)
      ->state('menu_item_type_article')->make();
    $this->user->quickLinks()->saveMany($quickLinks);
  }

  /**
   * Test retrieval of a user's Quick Links with no authentication.
   *
   * @return void
   */
  public function testGetQuickLinkUnauthenticated()
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
   * Test retrieval of a user's Quick Links with valid authentication.
   *
   * @return void
   */
  public function testGetQuickLinkWithAuth()
  {
    $response = $this->actingAs($this->user, 'api')
      ->getJson($this->getBaseURL());

    $response->assertSuccessful()
      ->assertJson(['success' => true])
      ->assertJsonStructure([
        'success',
        'data' => [
          'quick_links' => [],
        ],
      ]);
  }

}
