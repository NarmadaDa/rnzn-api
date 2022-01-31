<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\ForgotPasswordRequest;
use App\Services\PasswordService;

class PostForgotPassword extends Controller
{
  /**
   * @var App\Services\PasswordService
   */
  protected $passwordService;

  /**
   * PostForgotPassword constructor.
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
    
    $result = $this->passwordService->initiatePasswordReset($data["email"]);

    return redirect()->route('web.password.reset.show', [
      "email" => $data["email"]
    ]);
  }
}
