<?php

namespace Tests\Feature\Article;

use App\Models\Article;
use App\Models\MenuItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class DeleteArticleTest extends TestCase
{
  use RefreshDatabase;
  
  public function setUp(): void
  {
    parent::setUp();

    $this->setUserRole('admin');
  }

  /**
   * Test deletion of a Article with no authentication.
   *
   * @return void
   */
  public function testDeleteArticleUnauthenticated()
  {
    $article = factory(Article::class)->create();
    
    $path = 'articles/'.$article->slug;
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
   * Test deletion of a Article with no UUID.
   *
   * @return void
   */
  public function testDeleteArticleWithNoUuid()
  {
    $response = $this->actingAs($this->user, 'api')
      ->deleteJson($this->getURL('articles'));

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
   * Test deletion of a Article with invalid UUID.
   *
   * @return void
   */
  public function testDeleteArticleWithInvalidUuid()
  {
    $path = 'articles/invalid-uuid';
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
   * Test deletion of a Article with a non-existent UUID.
   *
   * @return void
   */
  public function testDeleteArticleWithNonExistentUuid()
  {
    $path = 'articles/'.$this->user->uuid;
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
   * Test deletion of a Article with valid details.
   *
   * @return void
   */
  public function testDeleteArticleWithValidDetails()
  {
    $article = factory(Article::class)->create();
    $path = 'articles/'.$article->uuid;

    $this->assertDatabaseHas('articles', $article->toArray());

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

    $this->assertSoftDeleted('articles', $article->toArray());
  }

  // TODO: fix related menu item tests below

  // /**
  //  * Test deletion of a Article and related Menu Item.
  //  *
  //  * @return void
  //  */
  // public function testDeleteArticleWithMenuItemRelationship()
  // {
  //   $menuItem = factory(MenuItem::class)->state('item_type_article')->create();
  //   $path = 'articles/'.$menuItem->item->uuid;

  //   $this->assertDatabaseHas('articles', $menuItem->item->toArray());
  //   $this->assertDatabaseHas('menu_items', $menuItem->toArray());

  //   $response = $this->actingAs($this->user, 'api')
  //     ->deleteJson($this->getURL($path));

  //   $response->dump();

  //   $response->assertSuccessful()
  //     ->assertJson(['success' => true])
  //     ->assertJsonStructure([
  //       'success',
  //       'data' => [
  //         'message',
  //       ],
  //     ]);

  //   $this->assertSoftDeleted('articles', $menuItem->item->toArray());
  //   $this->assertSoftDeleted('menu_items', $menuItem->toArray());
  // }
}
