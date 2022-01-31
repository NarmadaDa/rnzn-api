<?php

namespace App\Events\Interfaces;

use App\Models\SocialAccount;
use App\Models\SocialPost;
use Illuminate\Foundation\Events\Dispatchable;
use Log;

class FBPageEvent
{
  use Dispatchable;
   
  public $account, $oldestPost;

  /**
   * Create a new event instance.
   *
   * @param  \App\Models\SocialAccount  $account
   * @param  \App\Models\SocialPost  $oldestPost
   * @return void
   */
  public function __construct(SocialAccount $account, SocialPost $oldestPost = null)
  {
    $this->account = $account;
    $this->oldestPost = $oldestPost;
  }
}
