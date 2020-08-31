<?php

namespace App\Services\Interfaces;

use App\Http\Resources\CategoryResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

interface CategoryServiceInterface
{
    public function all(): AnonymousResourceCollection;

    public function create(array $attributes): CategoryResource;

    public function getById($id): CategoryResource;

    public function update($id, $data): CategoryResource;

    public function delete($id): ?bool;
}
