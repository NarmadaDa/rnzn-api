<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Models\Role;
use App\Repositories\Eloquent\UserRepository;
use DB;

class UpdateUser extends Controller
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
   * @param  \App\Http\Requests\Admin\UpdateUserRequest  $request
   * @param string $uuid
   * @return \Illuminate\Http\Response
   */
  public function __invoke(UpdateUserRequest $request, $uuid)
  {
    $data = $request->validated();

    DB::beginTransaction();

    try {
      $user = $this->userRepository->findByUUID($uuid);
      $user->load("profile", "roles", "userRole");

      $user->profile->first_name = ucfirst(strtolower($data["first_name"]));
      $user->profile->middle_name = strtoupper(
        substr($data["middle_name"], 0, 1)
      );
      $user->profile->last_name = ucfirst(strtolower($data["last_name"]));
      $user->profile->save();

      $role = Role::where("slug", $data["role"])->first();
      $user->userRole->role_id = $role->id;
      $user->userRole->save();
    } catch (Exception $e) {
      DB::rollback();
      abort(500, $e->getMessage());
    }

    DB::commit();

    return [
      "user" => $user->fresh()->load("profile", "roles"),
    ];
  }
}
