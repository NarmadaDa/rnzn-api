<?php

namespace Tests\Feature\News;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class GetAllNewsPostsTest extends TestCase
{
  use RefreshDatabase;

  private $posts;
  
  public function setUp(): void
  {
    parent::setUp();

    $this->posts = factory(Post::class, 10)->states('type_news')->create();
    
    $this->setEndpoint('news');
    $this->setUserRole('guest');
  }

  /**
   * Test retrieval of all News Posts with no authentication.
   *
   * @return void
   */
  public function testGetAllNewsPostsUnauthenticated()
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
   * Test retrieval of all News Posts with valid authentication and details.
   *
   * @return void
   */
  public function testGetAllNewsPostsWithValidDetails()
  {
    $response = $this->actingAs($this->user, 'api')
      ->getJson($this->getBaseURL());

    $response->assertSuccessful()
      ->assertJson(['success' => true])
      ->assertJsonStructure([
        'success',
        'data' => [
          'posts',
        ],
      ]);
  }

}
