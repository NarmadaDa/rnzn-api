<?php

namespace App\Http\Controllers\Channel;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\ChannelRepositoryInterface;

class BaseChannelController extends Controller
{
  /**
   * @var App\Repositories\Interfaces\ChannelRepositoryInterface
   */
  protected $channelRepository; 

  /**
   * BaseChannelController constructor.
   * 
   * @param App\Repositories\Interfaces\ChannelRepositoryInterface $channelRepository
   */
  public function __construct(
    ChannelRepositoryInterface $channelRepository
  )
  {
    $this->channelRepository = $channelRepository;
  }
}
