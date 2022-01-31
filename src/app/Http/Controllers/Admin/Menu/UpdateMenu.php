<?php

namespace App\Http\Controllers\Admin\Menu;

use App\Http\Controllers\Menu\BaseMenuController;
use App\Http\Requests\Menu\UpdateMenuRequest;
use App\Models\Menu;
use Illuminate\Validation\ValidationException;
use Validator;

class UpdateMenu extends BaseMenuController
{
  /**
   * Handle the incoming request.
   *
   * @param  \App\Http\Requests\Menu\UpdateMenuRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function __invoke(UpdateMenuRequest $request)
  {
    $data = $request->validated();

    $menu = $this->menuRepository->findByUUID($data["uuid"]);
    if (!$menu) {
      abort(404, "Menu does not exist.");
    }

    $sameSlug = $this->menuRepository->findBySlug($data["slug"]);
    if ($sameSlug && $menu->id !== $sameSlug->id) {
      $validator = Validator::make([], []);
      $validator->errors()->add("slug", "Slug already exists.");
      throw new ValidationException($validator);
    }

    $menu->name = $data["name"];
    $menu->slug = $data["slug"];
    $menu->save();

    return [
      "menu" => $menu,
    ];
  }
}
