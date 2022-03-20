<?php

namespace App\Repositories\Eloquent;

use App\Models\Student;
use App\Models\StudentMark;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\StudentRepositoryInterface;
use Illuminate\Support\Collection;

/**
 * Class StudentRepository
 * @package App\Repositories\Eloquent
 */
class StudentRepository extends BaseRepository implements StudentRepositoryInterface
{
  /**
   * StudentRepository constructor.
   * 
   * @param App\Models\Student $model
   */
  public function __construct(Student $model)
  {
    parent::__construct($model);
  }

  /**
  * @param string $id
  * @return App\Models\Student
  */
 public function findByStudentID(int $id): ?Student
 {
   return $this->model->where('id', $id) 
     ->first();
 }


  /**
   * @param array $attributes
   * @return Illuminate\Database\Eloquent\Model
   */
  public function create_student_marks($data)
  {  
    return StudentMark::create([
      "student_id"  => $data['student_id'],
      "final_mark"   => $data['final_mark'] 
    ]);

  }

  
}
