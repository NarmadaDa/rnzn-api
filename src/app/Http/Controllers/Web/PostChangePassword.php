<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\ChangePasswordRequest;
use App\Services\PasswordService;

class PostChangePassword extends Controller
{
  /**
   * @var App\Services\PasswordService
   */
  protected $passwordService;

  /**
   * PostChangePassword constructor.
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
   * @param  \App\Http\Requests\User\ChangePasswordRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function __invoke(ChangePasswordRequest $request)
  {
    $data = $request->validated();

    $result = $this->passwordService->changeUserPassword(
      $data["email"],
      $data["code"],
      $data["password"]
    );

    if (!$result) {
      return $this->abortUnauthorised();
    }
    
    return view("public.password.change", [
      "email" => "",
      "message" => "Your password has been updated."
    ]);
  }
}
