<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
// use Illuminate\Container\Container;
use Illuminate\Http\Request;
// use Illuminate\Mail\Markdown;
use Throwable;

class VerifyUserEmail extends Controller
{
  /**
   * Instantiate a new controller instance.
   *
   * @return void
   */
  // public function __construct()
  // {
  //   $this->middleware('signedhttps');
  // }

  /**
   * Handle the incoming request.
   *
   * @param  int  $id
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function __invoke($id, Request $request)
  {    
    try {
      $result = $request->hasValidSignature();
      $contentType = $request->header("Content-Type");
      if (!$result) {
        return $this->abort($contentType, 400, "Invalid verification data.");
      }

      $user = User::findOrFail($id);

      if ($user->hasVerifiedEmail()) {
        return $this->abort(
          $contentType,
          400,
          "Email address has already been verified."
        );
      }

      $user->markEmailAsVerified();
    } catch (Throwable $e) {
      // error
      return $this->abort(
        $contentType,
        400,
        "Email address has already been verified."
      );
    }

    // success
    return $this->return($contentType, [
      "message" => "Email address successfully verified.",
    ]);
  }

  private function return($contentType, $response)
  {
    if ($contentType == "application/json") {
      return $response;
    } else {
      return view("public.user.verify", $response);
    }
  }

  private function abort($contentType, $status, $error)
  {
    if ($contentType == "application/json") {
      return response()->json(
        [
          "success" => false,
          "data" => [
            "message" => $error,
          ],
        ],
        $status
      );
    } else {
      return view("public.user.verify", [
        "error" => $error,
      ]);
    }
  }
}
