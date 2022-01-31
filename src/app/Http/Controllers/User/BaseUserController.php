<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\UserRepositoryInterface;

class BaseUserController extends Controller
{
  /**
   * @var App\Repositories\Interfaces\UserRepositoryInterface
   */
  protected $userRepository;

  /**
   * BaseUserController constructor.
   *
   * @param App\Repositories\Interfaces\UserRepositoryInterface $userRepository
   */
  public function __construct(UserRepositoryInterface $userRepository)
  {
    $this->userRepository = $userRepository;
  }
}
