<?php

namespace App\Repositories\Eloquent;

use App\Models\Conditions;
use App\Models\User;
use App\Models\ConditionAcceptUsers;
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

   /**
   * @param string $uuid
   * @return App\Models\User
   */
  public function findByUUID(string $uuid)
  {
    return User::where('uuid', $uuid) 
      ->first();
  }

  /**
  * @param string $uuid
  * @return App\Models\Conditions
  */
 public function findByConditionID(int $id): ?Conditions
 {
   return $this->model->where('id', $id) 
     ->first();
 }

 
  /**
  * @param string $uuid
  * @return App\Models\ConditionAcceptUsers
  */
  public function findConditionByUUID(string $uuid)
  {
    return ConditionAcceptUsers::where('accepted_by', $uuid) 
      ->first();
  }
 

  /**
   * @param array $attributes
   * @return Illuminate\Database\Eloquent\Model
   */
  public function create_conditions_accepted_users($data)
  {  
    return ConditionAcceptUsers::create([
      "condition_id"  => $data['condition_id'],
      "accepted_by"   => $data['uuid'] 
    ]);

  }

  
}
