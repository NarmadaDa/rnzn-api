<?php

namespace App\Repositories\Interfaces;

use App\Models\Conditions;
use Illuminate\Support\Collection;

/**
 * Interface ConditionsRepositoryInterface
 * @package App\Repositories\Interfaces
 */
interface ConditionsRepositoryInterface
{
  /**
   * @return Illuminate\Support\Collection
   */
  public function all(): Collection;
}
