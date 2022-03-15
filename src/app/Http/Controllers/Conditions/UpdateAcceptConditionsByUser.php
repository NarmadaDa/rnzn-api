<?php

namespace App\Http\Controllers\Conditions;

use App\Http\Controllers\Conditions\BaseConditionsController;
use App\Http\Requests\Conditions\UpdateConditionRequest; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use App\Models\ConditionAcceptUsers;
use Exception;

class UpdateAcceptConditionsByUser extends BaseConditionsController
{
  /**
   * Handle the incoming request.
   *
   * @return \Illuminate\Http\Response
   */
  public function __invoke(UpdateConditionRequest $request)
  {  
    $data = $request->validated(); 
 
    $uuid = $this->conditionsRepository->findByUUID($data["uuid"]);
    if (!$uuid) {
      abort(404, "User does not exist.");
    }    
    
    $accepted = $this->conditionsRepository->findConditionByUUID($data["uuid"]);
    if ($accepted) {
      abort(404, "User already accepted.");
    }

    $condition_id = $this->conditionsRepository->findByConditionID($data["condition_id"]);
    if (!$condition_id) {
      abort(404, "Condition ID does not exist.");
    }

    DB::beginTransaction();

    try {    

      $this->conditionsRepository->create_conditions_accepted_users($data); 

    } catch (Exception $e) {
        DB::rollback();
        abort(500, $e->getMessage());
    }

    DB::commit();

    return [
      "message" => "Condition successfully accepted.",
    ];

  }
}
