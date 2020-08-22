<?php

namespace App\Services\Interfaces;

use App\Http\Resources\CategoryResource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface CategoryServiceInterface
{
    public function all(): Collection;

    public function create(array $attributes): CategoryResource;

    public function getById($id): Model;

    public function update($id, $data): CategoryResource;

    public function delete($id): ?bool;
}
