<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

class GetAASA extends Controller
{
  /**
   * Handle the incoming request.
   *
   * @return \Illuminate\Http\Response
   */
  public function __invoke()
  {
    $appID = config("app.apple_id");
    return response()->json([
      "applinks" => [
        "apps" => [],
        "details" => [
          [
            "appIDs" => [$appID],
            "components" => [
              [
                "/" => "/admin/*",
                "exclude" => true,
              ],
              [
                "/" => "/dashboard/*",
                "exclude" => true,
              ],
              [
                "/" => "/*",
              ],
            ],
          ],
        ],
      ],
      "webcredentials" => [
        "apps" => [],
      ],
      "appclips" => [
        "apps" => [],
      ],
    ]);
  }
}
