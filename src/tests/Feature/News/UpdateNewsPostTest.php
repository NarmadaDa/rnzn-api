<?php

namespace Tests\Feature\News;

use App\Models\Post;
use App\Models\PostType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class UpdateNewsPostTest extends TestCase
{
  use RefreshDatabase;

  private $post;
  
  public function setUp(): void
  {
    parent::setUp();

    $this->post = factory(Post::class)->state('type_news')->create();

    $path = 'news/'.$this->post->uuid;
    $this->setEndpoint($path);
    $this->setUserRole('admin');
  }

  /**
   * Test update of a News Post with no authentication.
   *
   * @return void
   */
  public function testUpdateNewsPostUnauthenticated()
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
   * Test update of a News Post with no details.
   *
   * @return void
   */
  public function testUpdateNewsPostWithNoDetails()
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
            'type',
            'content',
          ],
        ],
      ]);
  }

  /**
   * Test update of a News Post with invalid details.
   *
   * @return void
   */
  public function testUpdateNewsPostWithInvalidDetails()
  {
    $response = $this->actingAs($this->user, 'api')
      ->postJson($this->getBaseURL([
        'title'   => 123456789,
        'content' => '',
        'type'    => 'invalid type',
      ]));

    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
      ->assertJson(['success' => false])
      ->assertJsonStructure([
        'success',
        'data' => [
          'validation_errors' => [
            'title',
            'type',
            'content',
          ],
        ],
      ]);
  }

  /**
   * Test update of a News Post with valid details.
   *
   * @return void
   */
  public function testUpdateNewsPostWithValidDetails()
  {
    $type = factory(PostType::class)->state('type_news')->create();
    $post = [
      'title'   => 'Updated Test News Post',
      'content' => '<h1>Updated Test News Post</h1>',
    ];
    $data = $post;
    $data['type'] = $type->type;

    $response = $this->actingAs($this->user, 'api')
      ->postJson($this->getBaseURL(), $data);

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

    $this->assertDatabaseHas('posts', $post);
  }
  
}
