<?php

namespace Tests\Feature\Article;

use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class UpdateArticleTest extends TestCase
{
  use RefreshDatabase;

  private $article;
  
  public function setUp(): void
  {
    parent::setUp();

    $this->article = factory(Article::class)->create();

    $path = 'articles/'.$this->article->uuid;
    $this->setEndpoint($path);
    $this->setUserRole('admin');
  }

  /**
   * Test update of a Article with no authentication.
   *
   * @return void
   */
  public function testUpdateArticleUnauthenticated()
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
   * Test update of a Article with no details.
   *
   * @return void
   */
  public function testUpdateArticleWithNoDetails()
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
          ],
        ],
      ]);
  }

  /**
   * Test update of a Article with invalid details.
   *
   * @return void
   */
  public function testUpdateArticleWithInvalidDetails()
  {
    $response = $this->actingAs($this->user, 'api')
      ->postJson($this->getBaseURL([
        'title'   => 123456789,
        'slug'    => 'invalid slug',
        'content' => ''
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
          ],
        ],
      ]);
  }

  /**
   * Test update of a Article with a slug that already exists.
   *
   * @return void
   */
  public function testUpdateArticleWithWithExistingSlug()
  {
    $article = factory(Article::class)->create();

    $response = $this->actingAs($this->user, 'api')
      ->postJson($this->getBaseURL([
        'title'   => $article->title,
        'slug'    => $article->slug,
        'content' => $article->content,
      ]));

    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
      ->assertJson(['success' => false])
      ->assertJsonStructure([
        'success',
        'data' => [
          'validation_errors' => [
            'slug',
          ],
        ],
      ]);
  }

  /**
   * Test update of a Article with valid details.
   *
   * @return void
   */
  public function testUpdateArticleWithValidDetails()
  {
    $article = [
      'title'   => 'Updated Test Article',
      'slug'    => 'updated-test-article',
      'content' => '<h1>Updated Test Article</h1>',
    ];
    $response = $this->actingAs($this->user, 'api')
      ->postJson($this->getBaseURL(), $article);

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
          ],
        ],
      ]);

    $this->assertDatabaseHas('articles', $article);
  }
}
