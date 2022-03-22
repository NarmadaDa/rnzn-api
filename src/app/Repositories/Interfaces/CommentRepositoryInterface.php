<?php

namespace App\Repositories\Interfaces;

use App\Models\Comment; 

/**
 * Interface ChannelRepositoryInterface
 * @package App\Repositories\Interfaces
 */
interface CommentRepositoryInterface
{
  // /**
  //  * @param string $uuid
  //  * @return void
  //  */
  // public function deleteByUUID(string $uuid); 

  /**
   * @param string $uuid
   * @return App\Models\Comment
   */
  public function findByUUID(string $uuid): ?Comment;

  // /**
  //  * @param string $uuid
  //  * @return App\Models\Channel
  //  */
  // public function get_channel(): ?Channel;


}
