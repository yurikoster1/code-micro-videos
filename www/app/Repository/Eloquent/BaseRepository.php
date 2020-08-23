<?php

namespace App\Repository\Eloquent;

use App\Repository\Interfaces\EloquentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class BaseRepository implements EloquentRepositoryInterface
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * BaseRepository constructor.
     *
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @param array $attributes
     *
     * @return Model
     */
    public function create(array $attributes): Model
    {
        return $this->model->create($attributes);
    }

    /**
     * @param $id
     * @return Model
     */
    public function find($id): ?Model
    {
        $model = $this->model->find($id);
        if(!$model){
            throw  new ModelNotFoundException($this->model);
        }
        return $model;
    }

    /**
     * @param $id
     * @return bool|null
     * @throws \Exception
     */
    public function delete($id): ?bool
    {
        if (!empty($id)) {
            $model = $this->find($id);
            if ($model !== null) {
                return $model->delete();
            }
        }

        throw  new ModelNotFoundException($this->model);
    }

    public function update($id, array $data): bool
    {
        if (!empty($id)) {
            $model = $this->find($id);
            if ($model !== null) {
                return $model->update($data);
            }

        }
        throw new ModelNotFoundException($this->model);
    }
}
