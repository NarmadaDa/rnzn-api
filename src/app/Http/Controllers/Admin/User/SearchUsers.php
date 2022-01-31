<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\PaginatedController;
use App\Http\Requests\Admin\SearchUsersRequest;
use App\Models\User;
use DB;

class SearchUsers extends PaginatedController
{
  /**
   * Handle the incoming request.
   *
   * @param  \App\Http\Requests\Admin\SearchUsersRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function __invoke(SearchUsersRequest $request)
  {
    $data = $request->validated();

    // $orderCol = isset($data["order_col"]) ? $data["order_col"] : "created_at";
    // $orderDir = isset($data["order_dir"]) ? $data["order_dir"] : "desc";

    $search = isset($data["s"]) ? $data["s"] : null;

    $conditionalQuery =
      !empty($data["first_name"]) || !empty($data["last_name"]);

    $users = User::with(["profile", "roles"]);
    //   ->join('profiles', 'profiles.user_id', '=', 'users.id');

    $users = $users->whereHas("profile", function ($query) use ($data, $search) {
      if ($search) {
        $query
          ->whereRaw("LOWER(concat(first_name, ' ', last_name)) like ?", [
            "%" . strtolower($data["s"]) . "%",
          ])
          ->orWhere("email", "ilike", "%" . $data["s"] . "%");
      }

      if (!empty($data["first_name"])) {
        $multipleConditions = true;
        $query->where("first_name", "ilike", "%" . $data["first_name"] . "%");
      }

      if (!empty($data["last_name"])) {
        if ($multipleConditions) {
          $query->orWhere("last_name", "ilike", "%" . $data["last_name"] . "%");
        } else {
          $query->where("last_name", "ilike", "%" . $data["last_name"] . "%");
        }
      }
    });

    if (!empty($data["email"])) {
      $users = $conditionalQuery
        ? $users->orWhere("email", "like", "%" . $data["email"] . "%")
        : $users->where("email", "like", "%" . $data["email"] . "%");
    }

    // $users = User::select("*")
    //   ->join("profiles", "users.id", "=", "profiles.user_id")
    //   ->join("user_roles", "users.id", "=", "user_roles.user_id")
    //   ->join("roles", "user_roles.role_id", "=", "roles.id");
    // $users = User::with([
    //   "profile" => function ($query) use ($orderCol, $orderDir) {
    //     if ($orderCol === "name") {
    //       $query->orderBy("first_name", $orderDir);
    //       dd($query->toSql());
    //     }
    //   },
    //   "roles" => function ($query) use ($orderCol, $orderDir) {
    //     if ($orderCol === "role") {
    //       $query->orderBy("slug", $orderDir);
    //     }
    //   },
    // ]);

    // $users->whereHas("profile", function ($query) use (
    //   $data,
    //   $orderCol,
    //   $orderDir
    // ) {
    //   if (!empty($data["s"])) {
    //     $query
    //       ->whereRaw("LOWER(concat(first_name, ' ', last_name)) like ?", [
    //         "%" . strtolower($data["s"]) . "%",
    //       ])
    //       ->orWhere("email", "ilike", "%" . $data["s"] . "%");
    //   }

    //   if (!empty($data["first_name"])) {
    //     $multipleConditions = true;
    //     $query->where("first_name", "ilike", "%" . $data["first_name"] . "%");
    //   }

    //   if (!empty($data["last_name"])) {
    //     if ($multipleConditions) {
    //       $query->orWhere("last_name", "ilike", "%" . $data["last_name"] . "%");
    //     } else {
    //       $query->where("last_name", "ilike", "%" . $data["last_name"] . "%");
    //     }
    //   }

    //   // if ($orderCol === "name") {
    //   //   $query->orderBy("first_name", $orderDir);
    //   // }

    //   return $query;
    // });

    // if (!empty($data["email"])) {
    //   $users = $conditionalQuery
    //     ? $users->orWhere("email", "like", "%" . $data["email"] . "%")
    //     : $users->where("email", "like", "%" . $data["email"] . "%");
    // }

    $users->where("email", "LIKE", "%@%");

    // if ($orderCol === "name") {
    //   $users->orderBy("profiles.first_name", $orderDir);
    // } elseif ($orderCol === "email") {
    //   $users->orderBy("email", $orderDir);
    // } elseif ($orderCol === "status") {
    //   $users->orderBy("approved_at", $orderDir);
    // } elseif ($orderCol === "role") {
    //   $users->orderBy("roles.id", $orderDir);
    // } elseif ($orderCol === "created_at") {
    //   $users->orderBy("created_at", $orderDir);
    // }

    return $this->paginate("users", $users->paginate(10000));
  }
}
