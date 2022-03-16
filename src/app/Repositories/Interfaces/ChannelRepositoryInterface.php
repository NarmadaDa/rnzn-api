<?php

namespace App\Repositories\Interfaces;

use App\Models\Channel;

/**
 * Interface ChannelRepositoryInterface
 * @package App\Repositories\Interfaces
 */
interface ChannelRepositoryInterface
{
  /**
   * @param string $uuid
   * @return void
   */
  public function deleteByUUID(string $uuid); 

  /**
   * @param string $uuid
   * @return App\Models\Channel
   */
  public function findByUUID(string $uuid): ?Channel;

  // /**
  //  * @param string $uuid
  //  * @return App\Models\Channel
  //  */
  // public function get_channel(): ?Channel;
}
