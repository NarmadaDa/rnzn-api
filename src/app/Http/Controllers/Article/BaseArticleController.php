<?php

namespace App\Http\Controllers\Article;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\ArticleRepositoryInterface;
use App\Repositories\Interfaces\MenuItemRepositoryInterface;
use App\Repositories\Interfaces\RoleRepositoryInterface;

class BaseArticleController extends Controller
{
  /**
   * @var App\Repositories\Interfaces\ArticleRepositoryInterface
   */
  protected $articleRepository;

  /**
   * @var \App\Repositories\Interfaces\MenuItemRepositoryInterface
   */
  protected $menuItemRepository;

  /**
   * @var \App\Repositories\Interfaces\RoleRepositoryInterface
   */
  protected $roleRepository;

  /**
   * BaseArticleController constructor.
   * 
   * @param App\Repositories\Interfaces\ArticleRepositoryInterface $articleRepository
   * @param App\Repositories\Interfaces\MenuItemRepositoryInterface $menuItemRepository
   * @param App\Repositories\Interfaces\RoleRepositoryInterface $roleRepository
   */
  public function __construct(
    ArticleRepositoryInterface $articleRepository,
    MenuItemRepositoryInterface $menuItemRepository,
    RoleRepositoryInterface $roleRepository
  )
  {
    $this->articleRepository = $articleRepository;
    $this->menuItemRepository = $menuItemRepository;
    $this->roleRepository = $roleRepository;
  }
}
