<?php

namespace App\Repositories\Interfaces;

use App\Models\ForumPostReaction; 

/**
 * Interface ChannelRepositoryInterface
 * @package App\Repositories\Interfaces
 */
interface ForumpostreactionRepositoryInterface
{
  // /**
  //  * @param string $uuid
  //  * @return void
  //  */
  // public function deleteByUUID(string $uuid); 

  /**
   * @param string $uuid
   * @return App\Models\ForumPostReaction
   */
  public function findByUUID(string $uuid): ?ForumPostReaction;

  // /**
  //  * @param string $uuid
  //  * @return App\Models\Channel
  //  */
  // public function get_channel(): ?Channel;


}
