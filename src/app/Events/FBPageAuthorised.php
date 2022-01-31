<?php

namespace App\Events;

use App\Events\Interfaces\FBPageEvent;
use App\Models\SocialAccount;
use Illuminate\Foundation\Events\Dispatchable;
use Log;

class FBPageAuthorised extends FBPageEvent
{
  use Dispatchable;
  
  /**
   * Create a new event instance.
   *
   * @param  \App\Models\SocialAccount  $account
   * @return void
   */
  public function __construct(SocialAccount $account)
  {    
    parent::__construct($account);
  }
}
