<?php

namespace App\Http\Controllers\News;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\PostRepositoryInterface;
use App\Repositories\Interfaces\PostTypeRepositoryInterface;

class BasePostController extends Controller
{
  /**
   * @var App\Repositories\Interfaces\PostRepositoryInterface
   */
  protected $postRepository;

  /**
   * @var App\Repositories\Interfaces\PostTypeRepositoryInterface
   */
  protected $postTypeRepository;

  /**
   * BasePostController constructor.
   * 
   * @param App\Repositories\Interfaces\PostRepositoryInterface $postRepository
   * @param App\Repositories\Interfaces\PostTypeRepositoryInterface $postTypeRepository
   */
  public function __construct(
    PostRepositoryInterface $postRepository,
    PostTypeRepositoryInterface $postTypeRepository
  )
  {
    $this->postRepository = $postRepository;
    $this->postTypeRepository = $postTypeRepository;
  }
}
