<?php

namespace Tests\Feature\QuickLink;

use App\Models\MenuItem;
use App\Models\QuickLink;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class SearchQuickLinkOptionsTest extends TestCase
{
  use RefreshDatabase;

  private $menuItems;
  
  public function setUp(): void
  {
    parent::setUp();

    $this->menuItems = factory(MenuItem::class, 10)->states('item_type_article')->create();
    
    $this->setEndpoint('quicklinks/search');
    $this->setUserRole('personnel');
  }

  /**
   * Test searching Quick Link Options with no authentication.
   *
   * @return void
   */
  public function testSearchUnauthenticated()
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
   * Test searching Quick Link Options with no parameters.
   *
   * @return void
   */
  public function testSearchQuickLinkOptionsWithNoParameters()
  {
    $response = $this->actingAs($this->user, 'api')
      ->getJson($this->getBaseURL());

    $response->assertSuccessful()
      ->assertJson(['success' => true])
      ->assertJsonStructure([
        'success',
        'data' => [
          'search_results' => [],
        ],
      ]);
  }

  /**
   * Test searching Quick Link Options with a query.
   *
   * @return void
   */
  public function testSearchQuickLinkOptionsWithQuery()
  {
    $response = $this->actingAs($this->user, 'api')
      ->getJson($this->getBaseURL(), [
        'query' => 'a',
      ]);

    $response->assertSuccessful()
      ->assertJson(['success' => true])
      ->assertJsonStructure([
        'success',
        'data' => [
          'search_results' => [],
        ],
      ]);
  }

}
