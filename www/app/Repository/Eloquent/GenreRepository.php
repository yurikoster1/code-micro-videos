<?php


namespace App\Repository\Eloquent;

use App\Models\Genre;
use App\Repository\Interfaces\GenreRepositoryInterface;
use Illuminate\Support\Collection;

class GenreRepository extends BaseRepository implements GenreRepositoryInterface
{
    /**
     * GenreRepository constructor.
     *
     * @param Genre $model
     */
    public function __construct(Genre $model)
    {
        parent::__construct($model);
    }

    public function all(): Collection
    {
        return $this->model->all();
    }
}
