<?php

namespace App\Repositories\Interfaces;

use App\Models\Post;
use Illuminate\Support\Collection;

/**
 * Interface PostRepositoryInterface
 * @package App\Repositories\Interfaces
 */
interface PostRepositoryInterface
{
  /**
   * @param string $uuid
   * @return void
   */
  public function deleteByUUID(string $uuid);

  /**
   * @param string $uuid
   * @return App\Models\Post
   */
  public function findByUUID(string $uuid): ?Post;

  /**
   * @return Illuminate\Support\Collection
   */
  public function all(): Collection;
}
