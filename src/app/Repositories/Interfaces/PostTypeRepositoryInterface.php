<?php

namespace App\Repositories\Interfaces;

use App\Models\PostType;

/**
 * Interface PostTypeRepositoryInterface
 * @package App\Repositories\Interfaces
 */
interface PostTypeRepositoryInterface
{
  /**
   * @param string $type
   * @return App\Models\PostType
   */
  public function findByType(string $type): ?PostType;
}
