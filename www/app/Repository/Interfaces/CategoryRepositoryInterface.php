<?php


namespace App\Repository\Interfaces;

use App\Models\Category;
use Illuminate\Support\Collection;

interface CategoryRepositoryInterface extends EloquentRepositoryInterface
{
    public function all(): Collection;
}
