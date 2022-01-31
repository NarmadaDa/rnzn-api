<?php

namespace App\Jobs;

use App\Events\FBPageAuthorised;
use App\Models\SocialAccount;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Log;

class UpdateSocialPosts implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
      $accounts = SocialAccount::all();
      if (!$accounts || $accounts->count() === 0) {
        Log::info("Failed to find any Social Accounts");
      }

      $accounts->each(function($account) {
        FBPageAuthorised::dispatch($account);
      });
    }
}
