<?php

namespace App\Http\Controllers\Conditions;

use App\Http\Controllers\Conditions\BaseConditionsController;

class GetAllConditions extends BaseConditionsController
{
  /**
   * Handle the incoming request.
   *
   * @return \Illuminate\Http\Response
   */
  public function __invoke()
  {  
    $conditions = $this->conditionsRepository->termsAndConditions();
    
    return [
      'conditions' => $conditions,
    ];
  }
}
