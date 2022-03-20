<?php

namespace App\Repositories\Interfaces;

use App\Models\Student;
use Illuminate\Support\Collection;

/**
 * Interface ConditionsRepositoryInterface
 * @package App\Repositories\Interfaces
 */
interface StudentRepositoryInterface
{
  /**
   * @return Illuminate\Support\Collection
   */
  public function all(): Collection;
}
