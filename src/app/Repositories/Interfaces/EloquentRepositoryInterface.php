<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Interface EloquentRepositoryInterface
 * @package App\Repositories\Interfaces
 */
interface EloquentRepositoryInterface
{
  /**
   * @return Illuminate\Support\Collection
   */
  public function all(): Collection;

  /**
   * @param array $attributes
   * @return Illuminate\Database\Eloquent\Model
   */
  public function create(array $attributes): Model;

  /**
   * @param $id
   * @return Illuminate\Database\Eloquent\Model
   */
  public function find($id): ?Model;
}
