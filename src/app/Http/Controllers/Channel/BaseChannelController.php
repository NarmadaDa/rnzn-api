<?php

namespace App\Http\Controllers\Channel;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\ChannelRepositoryInterface;
use App\Repositories\Interfaces\ForumpostRepositoryInterface;
use App\Repositories\Interfaces\InappropriateRepositoryInterface;

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
   * BaseChannelController constructor.
   * 
   * @param App\Repositories\Interfaces\ChannelRepositoryInterface $channelRepository
   * @param App\Repositories\Interfaces\ForumpostRepositoryInterface $formpostRepository
   * @param App\Repositories\Interfaces\InappropriateRepositoryInterface $inappropriateRepository
   */
  public function __construct(
    ChannelRepositoryInterface $channelRepository,
    ForumpostRepositoryInterface $formpostRepository,
    InappropriateRepositoryInterface $inappropriateRepository
  )
  {
    $this->channelRepository = $channelRepository;
    $this->formpostRepository = $formpostRepository;
    $this->inappropriateRepository = $inappropriateRepository;
  }
}
