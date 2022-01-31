<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\ForgotPasswordRequest;
use App\Services\PasswordService;

class ForgotPassword extends Controller
{
  /**
   * @var App\Services\PasswordService
   */
  protected $passwordService;

  /**
   * BaseMenuController constructor.
   * 
   * @param App\Services\PasswordService $menuRepository
   */
  public function __construct(PasswordService $passwordService)
  {
    $this->passwordService = $passwordService;
  }

  /**
   * Handle the incoming request.
   *
   * @param  \App\Http\Requests\User\ForgotPasswordRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function __invoke(ForgotPasswordRequest $request)
  {
    $data = $request->validated();
    
    $this->passwordService->initiatePasswordReset($data["email"]);

    return $this->response();
  }

  private function response()
  {
    return [
      "message" => "Please check your emails.",
    ];
  }
}
