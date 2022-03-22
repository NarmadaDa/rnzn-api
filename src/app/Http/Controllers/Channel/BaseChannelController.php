<?php

namespace App\Http\Controllers\Channel;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\ChannelRepositoryInterface;
use App\Repositories\Interfaces\ForumpostRepositoryInterface;
use App\Repositories\Interfaces\InappropriateRepositoryInterface;
// use App\Repositories\Interfaces\CommentRepositoryInterface;

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
   * @var App\Repositories\Interfaces\CommentRepositoryInterface
   */
  // protected $commentRepository; 

  /**
   * BaseChannelController constructor.
   * 
   * @param App\Repositories\Interfaces\ChannelRepositoryInterface $channelRepository
   * @param App\Repositories\Interfaces\ForumpostRepositoryInterface $formpostRepository
   * @param App\Repositories\Interfaces\InappropriateRepositoryInterface $inappropriateRepository
   * @param App\Repositories\Interfaces\CommentRepositoryInterface $commentRepository
   */
  public function __construct(
    ChannelRepositoryInterface $channelRepository,
    ForumpostRepositoryInterface $formpostRepository,
    InappropriateRepositoryInterface $inappropriateRepository
    // CommentRepositoryInterface $commentRepository
  )
  {
    $this->channelRepository = $channelRepository;
    $this->formpostRepository = $formpostRepository;
    $this->inappropriateRepository = $inappropriateRepository;
    // $this->commentRepository = $commentRepository;
  }
}
