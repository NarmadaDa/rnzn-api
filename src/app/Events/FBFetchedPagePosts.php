<?php

namespace App\Events;

use App\Events\Interfaces\FBPageEvent;
use App\Models\SocialAccount;
use App\Models\SocialPost;
use Illuminate\Foundation\Events\Dispatchable;
use Log;

class FBFetchedPagePosts extends FBPageEvent
{
  use Dispatchable;
  
  /**
   * Create a new event instance.
   *
   * @param  \App\Models\SocialAccount  $account
   * @return void
   */
  public function __construct(SocialAccount $account, SocialPost $oldestPost)
  {
    Log::info("--> FBFetchedPagePosts");
    
    parent::__construct($account, $oldestPost);
  }
}
