<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Student\BaseStudentController;
use App\Http\Requests\Student\UpdateMarksRequest; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use App\Models\StudentMark;
use Exception;

class UpdateStudentMarks extends BaseStudentController
{
  /**
   * Handle the incoming request.
   *
   * @return \Illuminate\Http\Response
   */
  public function __invoke(UpdateMarksRequest $request)
  {  
    $data = $request->validated(); 
 

    $student_id = $this->studentRepository->findByStudentID($data["student_id"]);
    if (!$student_id) {
      abort(404, "Student does not exist.");
    }

    DB::beginTransaction();

    try {    

      $this->studentRepository->create_student_marks($data);

    } catch (Exception $e) {
        DB::rollback();
        abort(500, $e->getMessage());
    }

    DB::commit();

    return [
      "message" => "Marks successfully entered.",
    ];

  }
}
