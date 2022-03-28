<?php

namespace App\Http\Controllers\Channel;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\ChannelRepositoryInterface;
use App\Repositories\Interfaces\ForumpostRepositoryInterface;
use App\Repositories\Interfaces\InappropriateRepositoryInterface;
use App\Repositories\Interfaces\ForumpostreactionRepositoryInterface; 
use App\Repositories\Interfaces\PinPostRepositoryInterface;

class BaseChannelController extends Controller
{
  /**
   * @var App\Repositories\Interfaces\ChannelRepositoryInterface
   */
  protected $channelRepository; 

  /**
   * @var App\Repositories\Interfaces\ForumpostRepositoryInterface
   */
  protected $formpostRepository;  

  /**
   * @var App\Repositories\Interfaces\InappropriateRepositoryInterface
   */
  protected $inappropriateRepository;

  /**
   * @var App\Repositories\Interfaces\ForumpostreactionRepositoryInterface
   */
  protected $forumpostreactionRepository; 

    /**
   * @var App\Repositories\Interfaces\PinPostRepositoryInterface
   */
  protected $pinpostRepository;
  

  /**
   * BaseChannelController constructor.
   * 
   * @param App\Repositories\Interfaces\ChannelRepositoryInterface $channelRepository
   * @param App\Repositories\Interfaces\ForumpostRepositoryInterface $formpostRepository
   * @param App\Repositories\Interfaces\InappropriateRepositoryInterface $inappropriateRepository
   * @param App\Repositories\Interfaces\ForumpostreactionRepositoryInterface $forumpostreactionRepository  
   * @param App\Repositories\Interfaces\PinPostRepositoryInterface $pinpostRepository
   */
  public function __construct(
    ChannelRepositoryInterface $channelRepository,
    ForumpostRepositoryInterface $formpostRepository,
    InappropriateRepositoryInterface $inappropriateRepository,
    ForumpostreactionRepositoryInterface $forumpostreactionRepository,
    PinPostRepositoryInterface $pinpostRepository
  )
  {
    $this->channelRepository = $channelRepository;
    $this->formpostRepository = $formpostRepository;
    $this->inappropriateRepository = $inappropriateRepository;
    $this->forumpostreactionRepository = $forumpostreactionRepository; 
    $this->pinpostRepository = $pinpostRepository;
  }
}
