<?php

namespace App\Http\Controllers\Admin\Feedback;

use App\Http\Controllers\PaginatedController;
use App\Models\Article;
use App\Models\ArticleFeedback;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class GetArticleFeedback extends PaginatedController
{
  /**
   * Handle the incoming request.
   *
   * @param  Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function __invoke(Request $request)
  {
    $page = $request->get("page", 1);
    $size = $request->get("page_size", 10);
    $offset = $size * ($page - 1);

    $query = "
      SELECT
        a.title AS title,
        a.slug LIKE 'guest%' AS is_guest,
        a.uuid AS article_id,
        COUNT(f.rating) AS total_ratings,
        ROUND(AVG(f.rating)) AS average_rating,
        MAX(f.rating) as max_rating,
        MIN(f.rating) as min_rating
      FROM articles AS a, article_feedback AS f
      WHERE a.id = f.article_id
      GROUP BY a.id
      ORDER BY a.title ASC
    ";

    $results = collect(DB::select($query));
    $total = $results->count();
    $feedback = $results->skip($offset)->take($size);
    $paginator = new LengthAwarePaginator($feedback, $total, $size, $page);

    return $this->paginate("article_feedback", $paginator);
  }
}
