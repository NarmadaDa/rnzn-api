<?php

namespace App\Http\Controllers\Admin\Article;

use App\Http\Controllers\Article\BaseArticleController; 
use App\Http\Requests\Article\SortArticleRequest;
use App\Models\Article;
use Exception;
use Illuminate\Support\Facades\DB;

class ShortlistArticleSort extends BaseArticleController
{
  /**
   * Handle the incoming request.
   *
   * @param  \App\Http\Requests\Article\SortArticleRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function __invoke(SortArticleRequest $request)
  {
    $data = $request->validated();  
 
    DB::beginTransaction();

    try {

      foreach($data["order"] as $uuid => $order){
        Article::where('uuid', $uuid)->update(['shortlist' => true, 'shortlist_order' => $order]);
      }

    } catch (Exception $e) {
      DB::rollback();
      abort(500, $e->getMessage());
    }

    DB::commit();

    return [
      "message" => "Shortlisted Articles Successfully Sorted.",
    ];
  }
}
