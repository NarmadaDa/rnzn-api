<?php

namespace App\Repositories\Interfaces;

use App\Models\ForumPost;

/**
 * Interface PinPostRepositoryInterface
 * @package App\Repositories\Interfaces
 */
interface PinPostRepositoryInterface
{ 
  /**
   * @param string $uuid
   * @return App\Models\ForumPost
   */
  public function findByUUID(string $uuid): ?ForumPost;

 
}
