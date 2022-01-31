<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\User\BaseUserController;
use App\Http\Requests\Admin\ApproveUserRequest;
use App\Mail\UserApprovedEmail;
use App\Models\Role;
use Carbon\Carbon;
use DB;
use Mail;

class ApproveUser extends BaseUserController
{
  /**
   * Handle the incoming request.
   *
   * @param  \App\Http\Requests\User\ApproveUserRequest  $request
   * @param string $uuid
   * @return \Illuminate\Http\Response
   */
  public function __invoke(ApproveUserRequest $request)
  {
    $data = $request->validated();
    $admin = $request->user();
    
    DB::beginTransaction();

    try {

      $user = $this->userRepository->findByUUID($data["uuid"]);

      if (!$user) {
        abort(404, "User not found.");
      }

      $role = Role::where("slug", $data["role"])->first();
      if (!$role) {
        abort(422, "Invalid Role.");
      }

      $user->userRole->role_id = $role->id;
      $user->userRole->save();

      $user->approved_at = Carbon::now()->format("Y-m-d H:i:s");
      $user->approved_by = $admin->id;
      $user->save();
      $email = new UserApprovedEmail($user);
      
      Mail::to($user)->send($email);

    } catch (Exception $e) {
      DB::rollback();
      abort(500, $e->getMessage());
    }

    DB::commit();

    return [
      "message" => "User has been approved.",
    ];
  }
}
