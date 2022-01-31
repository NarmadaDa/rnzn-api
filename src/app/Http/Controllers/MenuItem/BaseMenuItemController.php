<?php

namespace App\Http\Controllers\MenuItem;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\ArticleRepositoryInterface;
use App\Repositories\Interfaces\MenuItemRepositoryInterface;
use App\Repositories\Interfaces\MenuRepositoryInterface;

class BaseMenuItemController extends Controller
{
  /**
   * @var \App\Repositories\Interfaces\ArticleRepositoryInterface
   */
  protected $articleRepository;

  /**
   * @var \App\Repositories\Interfaces\MenuItemRepositoryInterface
   */
  protected $menuItemRepository;

  /**
   * @var \App\Repositories\Interfaces\MenuRepositoryInterface
   */
  protected $menuRepository;

  /**
   * BaseMenuItemController constructor.
   * 
   * @param \App\Repositories\Interfaces\ArticleRepositoryInterface $articleRepository
   * @param \App\Repositories\Interfaces\MenuItemRepositoryInterface $menuItemRepository
   * @param \App\Repositories\Interfaces\MenuRepositoryInterface $menuRepository
   */
  public function __construct(
    ArticleRepositoryInterface $articleRepository,
    MenuItemRepositoryInterface $menuItemRepository,
    MenuRepositoryInterface $menuRepository
  )
  {
    $this->articleRepository = $articleRepository;
    $this->menuItemRepository = $menuItemRepository;
    $this->menuRepository = $menuRepository;
  }
}
