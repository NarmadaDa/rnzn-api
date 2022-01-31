<?php

namespace App\Repositories\Interfaces;

use App\Models\Article;

/**
 * Interface ArticleRepositoryInterface
 * @package App\Repositories\Interfaces
 */
interface ArticleRepositoryInterface
{
  /**
   * @param string $uuid
   * @return void
   */
  public function deleteByUUID(string $uuid);

  /**
   * @param string $slug
   * @return App\Models\Article
   */
  public function findBySlug(string $slug): ?Article;

  /**
   * @param string $uuid
   * @return App\Models\Article
   */
  public function findByUUID(string $uuid): ?Article;
}
