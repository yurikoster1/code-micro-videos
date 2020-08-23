<?php


namespace App\Repository\Interfaces;

use App\Models\Genre;
use Illuminate\Support\Collection;

interface GenreRepositoryInterface extends EloquentRepositoryInterface
{
    public function all(): Collection;

}
