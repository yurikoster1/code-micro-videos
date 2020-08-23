<?php

namespace App\Services\Interfaces;

use App\Http\Resources\GenreResource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface GenreServiceInterface
{
    public function all(): Collection;

    public function create(array $attributes): GenreResource;

    public function getById($id): Model;

    public function update($id, $data): GenreResource;

    public function delete($id): ?bool;
}
