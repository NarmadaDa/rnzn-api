<?php

namespace Tests\Feature\Article;

use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class GetArticleBySlugTest extends TestCase
{
  use RefreshDatabase;

  private $article;
  
  public function setUp(): void
  {
    parent::setUp();

    $this->article = factory(Article::class)->create();
    
    $path = 'articles/'.$this->article->slug;
    $this->setEndpoint($path);
    $this->setUserRole('guest');
  }

  /**
   * Test retrieval of Article with no authentication.
   *
   * @return void
   */
  public function testGetArticleUnauthenticated()
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
   * Test retrieval of Article with invalid slug.
   *
   * @return void
   */
  public function testGetArticleWithInvalidSlug()
  {
    $response = $this->actingAs($this->user, 'api')
      ->getJson($this->getURL('articles/invalid-slug'));

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
   * Test retrieval of Article with valid authentication and details.
   *
   * @return void
   */
  public function testGetArticleWithAuth()
  {
    $article = factory(Article::class)->create();
    $this->setEndpoint('articles/'.$article->slug);

    $response = $this->actingAs($this->user, 'api')
      ->getJson($this->getBaseURL());

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
  }

}
