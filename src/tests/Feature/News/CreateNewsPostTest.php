<?php

namespace Tests\Feature\News;

use App\Models\Post;
use App\Models\PostType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class CreateNewsPostTest extends TestCase
{
  use RefreshDatabase;
  
  public function setUp(): void
  {
    parent::setUp();

    $this->setEndpoint('news');
    $this->setUserRole('admin');
  }

  /**
   * Test creation of a News Post with no authentication.
   *
   * @return void
   */
  public function testCreateNewsPostUnauthenticated()
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
   * Test creation of a News Post with no details.
   *
   * @return void
   */
  public function testCreateNewsPostWithNoDetails()
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
   * Test creation of a News Post with invalid details.
   *
   * @return void
   */
  public function testCreateNewsPostWithInvalidDetails()
  {
    $response = $this->actingAs($this->user, 'api')
      ->postJson($this->getBaseURL([
        'title'   => 123456789,
        'type'    => 123456789,
        'content' => '',
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
   * Test creation of a News Post with valid details.
   *
   * @return void
   */
  public function testCreateNewsPostWithValidDetails()
  {
    $type = factory(PostType::class)->state('type_news')->create();
    $post = [
      'title'   => 'Test Post',
      'content' => '<h1>Test Post</h1>',
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
            // 'type',
            'content',
          ],
        ],
      ]);

    $this->assertDatabaseHas('posts', $post);
  }
}
