<?php

namespace App\Repositories\Interfaces;

use App\Models\ForumPost;

/**
 * Interface InappropriateRepositoryInterface
 * @package App\Repositories\Interfaces
 */
interface InappropriateRepositoryInterface
{ 
  /**
   * @param string $uuid
   * @return App\Models\ForumPost
   */
  public function findByUUID(string $uuid): ?ForumPost;
 
}
