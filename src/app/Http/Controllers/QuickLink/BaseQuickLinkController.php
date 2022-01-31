<?php

namespace App\Http\Controllers\QuickLink;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\MenuItemRepositoryInterface;
use App\Repositories\Interfaces\QuickLinkRepositoryInterface;

class BaseQuickLinkController extends Controller
{
  /**
   * @var \App\Repositories\Interfaces\MenuItemRepositoryInterface
   */
  protected $menuItemRepository;
  
  /**
   * @var App\Repositories\Interfaces\QuickLinkRepositoryInterface
   */
  protected $quickLinkRepository;

  /**
   * BaseArticleController constructor.
   * 
   * @param App\Repositories\Interfaces\MenuItemRepositoryInterface $menuItemRepository
   * @param App\Repositories\Interfaces\QuickLinkRepositoryInterface $quickLinkRepository
   */
  public function __construct(
    MenuItemRepositoryInterface $menuItemRepository,
    QuickLinkRepositoryInterface $quickLinkRepository
  )
  {
    $this->menuItemRepository = $menuItemRepository;
    $this->quickLinkRepository = $quickLinkRepository;
  }
}
