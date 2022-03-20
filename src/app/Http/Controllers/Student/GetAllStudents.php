<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Student\BaseStudentController;

class GetAllStudents extends BaseStudentController
{
  /**
   * Handle the incoming request.
   *
   * @return \Illuminate\Http\Response
   */
  public function __invoke()
  {  
    $students = $this->studentRepository->all();
    
    return [
      'students' => $students,
    ];
  }
}
