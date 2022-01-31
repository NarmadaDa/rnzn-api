<?php

namespace Tests\Feature\News;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class GetNewsPostTest extends TestCase
{
  use RefreshDatabase;

  private $post;
  
  public function setUp(): void
  {
    parent::setUp();

    $this->post = factory(Post::class)->state('type_news')->create();
    
    $path = 'news/'.$this->post->uuid;
    $this->setEndpoint($path);
    $this->setUserRole('guest');
  }

  /**
   * Test retrieval of News Post with no authentication.
   *
   * @return void
   */
  public function testGetNewsPostUnauthenticated()
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
   * Test retrieval of a News Post with a non-existent UUID.
   *
   * @return void
   */
  public function testGetNewsPostWithNonExistentUuid()
  {
    $path = 'news/'.$this->user->uuid;
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
   * Test retrieval of News Post with valid authentication and details.
   *
   * @return void
   */
  public function testGetNewsPostWithValidDetails()
  {
    $this->setEndpoint('news/'.$this->post->uuid);

    $response = $this->actingAs($this->user, 'api')
      ->getJson($this->getBaseURL());

    $response->assertSuccessful()
      ->assertJson(['success' => true])
      ->assertJsonStructure([
        'success',
        'data' => [
          'post' => [
            'uuid',
            'title',
            'content',
            'type',
          ],
        ],
      ]);
  }

}
