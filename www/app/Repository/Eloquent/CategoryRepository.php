<?php


namespace App\Repository\Eloquent;

use App\Models\Category;
use App\Repository\Interfaces\CategoryRepositoryInterface;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{
    public  $rules = [
        ''
    ];
    /**
     * GenreRepository constructor.
     *
     * @param Category $model
     */
    public function __construct(Category $model)
    {
        parent::__construct($model);
    }

    public function all(): Collection
    {
        return $this->model->all();
    }
}
