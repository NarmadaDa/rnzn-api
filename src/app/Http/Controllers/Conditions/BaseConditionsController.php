<?php

namespace App\Http\Controllers\Conditions;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\ConditionsRepositoryInterface;
use App\Repositories\Interfaces\ConditionsTypeRepositoryInterface;

class BaseConditionsController extends Controller
{
  /**
   * @var App\Repositories\Interfaces\ConditionsRepositoryInterface
   */
  protected $conditionsRepository;

  /**
   * BaseConditionsController constructor.
   * 
   * @param App\Repositories\Interfaces\ConditionsRepositoryInterface $postRepository

   */
  public function __construct(ConditionsRepositoryInterface $conditionsRepository)
  {
    $this->conditionsRepository = $conditionsRepository;
  }
}
