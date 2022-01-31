<?php

namespace App\Http\Controllers\Menu;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\MenuRepositoryInterface;

class BaseMenuController extends Controller
{
  /**
   * @var App\Repositories\Interfaces\MenuRepositoryInterface
   */
  protected $menuRepository;

  /**
   * BaseMenuController constructor.
   * 
   * @param App\Repositories\Interfaces\MenuRepositoryInterface $menuRepository
   */
  public function __construct(MenuRepositoryInterface $menuRepository)
  {
    $this->menuRepository = $menuRepository;
  }
}
