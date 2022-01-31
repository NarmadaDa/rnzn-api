<?php

namespace App\Repositories;

use App\Repositories\Interfaces\EloquentRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Class BaseRepository
 * @package App\Repositories
 */
class BaseRepository implements EloquentRepositoryInterface
{
  /**
   * @var Illuminate\Database\Eloquent\Model
   */
  protected $model;

  /**
   * BaseRepository constructor.
   * 
   * @param Illuminate\Database\Eloquent\Model $model
   */
  public function __construct(Model $model)
  {
    $this->model = $model;
  }

  /**
   * @return Illuminate\Support\Collection
   */
  public function all(): Collection
  {
    return $this->model->all();
  }

  /**
   * @param array $attributes
   * @return Illuminate\Database\Eloquent\Model
   */
  public function create(array $attributes): Model
  {
    return $this->model->create($attributes);
  }

  /**
   * @param $id
   * @return Illuminate\Database\Eloquent\Model
   */
  public function find($id): ?Model
  {
    return $this->model->find($id);
  }
}
