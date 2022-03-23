<?php

namespace App\Http\Controllers\Conditions;

use App\Http\Controllers\Conditions\BaseConditionsController;
use App\Http\Requests\Conditions\VerifyConditionRequest; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use App\Models\ConditionAcceptUsers;
use Exception;

class VerifyAcceptConditionsByUser extends BaseConditionsController
{
  /**
   * Handle the incoming request.
   *
   * @return \Illuminate\Http\Response
   */
  public function __invoke(VerifyConditionRequest $request)
  {  
    $data = $request->validated(); 
    
    $uuid = $this->conditionsRepository->findByUUID($data["uuid"]);
    if (!$uuid) {
      abort(404, "User has not accepted condition.");
    }   
        
    return [
        'message' => "User has already accepted conditions.",
      ];
  }
}
