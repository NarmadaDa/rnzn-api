<?php

namespace App\Repositories\Eloquent;

use App\Models\Conditions;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\ConditionsRepositoryInterface;
use Illuminate\Support\Collection;

/**
 * Class ConditionsRepository
 * @package App\Repositories\Eloquent
 */
class ConditionsRepository extends BaseRepository implements ConditionsRepositoryInterface
{
  /**
   * ConditionsRepository constructor.
   * 
   * @param App\Models\Conditions $model
   */
  public function __construct(Conditions $model)
  {
    parent::__construct($model);
  }

  /**
   * @return only terms and conditions
   */
  public function termsAndConditions()
  {
    return $this->model->where('title', 'terms and conditions')
      ->first();
  }
}
