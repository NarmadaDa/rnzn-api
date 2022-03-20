<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\StudentRepositoryInterface;

class BaseStudentController extends Controller
{
  /**
   * @var App\Repositories\Interfaces\StudentRepositoryInterface
   */
  protected $studentRepository;

  /**
   * BaseStudentController constructor.
   * 
   * @param App\Repositories\Interfaces\StudentRepositoryInterface $studentRepository

   */
  public function __construct(StudentRepositoryInterface $studentRepository)
  {
    $this->studentRepository = $studentRepository;
  }
}
