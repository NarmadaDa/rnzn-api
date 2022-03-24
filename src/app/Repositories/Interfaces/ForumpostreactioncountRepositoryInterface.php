<?php

namespace App\Repositories\Interfaces;

use App\Models\ForumPostReactionCount; 

/**
 * Interface ChannelRepositoryInterface
 * @package App\Repositories\Interfaces
 */
interface ForumpostreactioncountRepositoryInterface
{
  // /**
  //  * @param string $uuid
  //  * @return void
  //  */
  // public function deleteByUUID(string $uuid); 

  /**
   * @param string $uuid
   * @return App\Models\ForumPostReactionCount
   */
  public function findByUUID(string $uuid): ?ForumPostReactionCount;

  /**
   * @param string $uuid
   * @return App\Models\ForumPostReactionCount
   */
  public function findReactionByUser(string $uuid, int $user_id): ?ForumPostReactionCount;

  /**
   * @param string $uuid
   * @return App\Models\ForumPostReactionCount
   */
  public function findByPostID(int $id): ?ForumPostReactionCount;
  

}
