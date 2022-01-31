<?php

namespace Tests\Feature\Article;

use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class CreateArticleTest extends TestCase
{
  use RefreshDatabase;
  
  public function setUp(): void
  {
    parent::setUp();

    $this->setEndpoint('articles');
    $this->setUserRole('admin');
  }

  /**
   * Test creation of a Article with no authentication.
   *
   * @return void
   */
  public function testCreateArticleUnauthenticated()
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
   * Test creation of a Article with no details.
   *
   * @return void
   */
  public function testCreateArticleWithNoDetails()
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
            'content',
            'roles',
          ],
        ],
      ]);
  }

  /**
   * Test creation of a Article with invalid details.
   *
   * @return void
   */
  public function testCreateArticleWithInvalidDetails()
  {
    $response = $this->actingAs($this->user, 'api')
      ->postJson($this->getBaseURL([
        'title'   => 123456789,
        'slug'    => 'invalid slug',
        'content' => '',
        'roles'   => 'not an array',
      ]));

    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
      ->assertJson(['success' => false])
      ->assertJsonStructure([
        'success',
        'data' => [
          'validation_errors' => [
            'title',
            'slug',
            'content',
            'roles',
          ],
        ],
      ]);
  }

  /**
   * Test creation of a Article with valid details.
   *
   * @return void
   */
  public function testCreateArticleWithValidDetails()
  {
    $article = [
      'title'   => 'Test Article',
      'slug'    => 'test-article',
      'content' => '<h1>Test Article</h1>',
    ];
    $data = $article;
    $data['roles'] = ['guest'];

    $response = $this->actingAs($this->user, 'api')
      ->postJson($this->getBaseURL(), $data);

    $response->assertSuccessful()
      ->assertJson(['success' => true])
      ->assertJsonStructure([
        'success',
        'data' => [
          'article' => [
            'uuid',
            'title',
            'slug',
            'content',
            'roles',
          ],
        ],
      ]);

    $this->assertDatabaseHas('articles', $article);
  }
}
