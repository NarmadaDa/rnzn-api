<?php

namespace Tests\Feature\News;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class DeleteNewsPostTest extends TestCase
{
  use RefreshDatabase;
  
  public function setUp(): void
  {
    parent::setUp();

    $this->setUserRole('admin');
  }

  /**
   * Test deletion of a News Post with no authentication.
   *
   * @return void
   */
  public function testDeleteNewsPostUnauthenticated()
  {
    $post = factory(Post::class)->state('type_news')->create();
    
    $path = 'news/'.$post->uuid;
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
   * Test deletion of a News Post with no UUID.
   *
   * @return void
   */
  public function testDeleteNewsPostWithNoUuid()
  {
    $response = $this->actingAs($this->user, 'api')
      ->deleteJson($this->getURL('news'));

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
   * Test deletion of a News Post with invalid UUID.
   *
   * @return void
   */
  public function testDeleteNewsPostWithInvalidUuid()
  {
    $path = 'news/invalid-uuid';
    $response = $this->actingAs($this->user, 'api')
      ->deleteJson($this->getURL($path));

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
   * Test deletion of a News Post with a non-existent UUID.
   *
   * @return void
   */
  public function testDeleteNewsPostWithNonExistentUuid()
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
   * Test deletion of a News Post with valid details.
   *
   * @return void
   */
  public function testDeleteNewsPostWithValidDetails()
  {
    $post = factory(Post::class)->state('type_news')->create();
    $path = 'news/'.$post->uuid;

    $this->assertDatabaseHas('posts', $post->toArray());

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

    $this->assertSoftDeleted('posts', $post->toArray());
  }
}
