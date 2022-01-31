<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\User\BaseUserController;
use App\Http\Requests\Admin\DeleteUserRequest;
use App\Repositories\Eloquent\UserRepository;

class DeleteUser extends BaseUserController
{
  protected $userRepository;

  /**
   * Constructor
   * @param UserRepository $userRepository
   */
  public function __construct(UserRepository $userRepository)
  {
    $this->userRepository = $userRepository;
  }

  /**
   * Handle the incoming request.
   *
   * @param  \App\Http\Requests\Admin\DeleteUserRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function __invoke(DeleteUserRequest $request)
  {
    $data = $request->validated();

    $user = $this->userRepository->findByUUID($data["uuid"]);
    if (!$user) {
      abort(404, "User does not exist.");
    }

    $admin = $request->user();

    $user->deleted_by = $admin->id;
    $user->save();
    $user->delete();

    return [
      "message" => "User successfully deleted.",
    ];
  }
}
