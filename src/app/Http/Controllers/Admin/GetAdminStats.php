<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ArticleFeedback;
use App\Models\UserFeedback;
use App\Models\SocialAccount;
use App\Models\User;
use Illuminate\Http\Request;

class GetAdminStats extends Controller
{
  /**
   * Handle the incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function __invoke(Request $request)
  {
    $unapproved = User::nonGuests()
      ->whereNull("approved_at")
      ->count();
    $users = User::all()->count();
    $userFeedback = UserFeedback::all()->count();
    $articles = Article::all()->count();
    $articleFeedback = ArticleFeedback::all()->count();
    $social = SocialAccount::all()->count();

    return [
      "stats" => [
        "total_unapproved_users" => $unapproved,
        "total_users" => $users,
        "total_articles" => $articles,
        "total_feedback_articles" => $articleFeedback,
        "total_feedback_app" => $userFeedback,
        "total_social_accounts" => $social,
      ],
    ];
  }
}
