<?php

namespace App\Services;

use App\Http\Resources\GenreResource;
use App\Repository\Interfaces\GenreRepositoryInterface;
use App\Services\Interfaces\GenreServiceInterface;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Collection;
use Throwable;

class GenreService implements GenreServiceInterface
{
    private $genreRepository;

    /**
     * CategoryService constructor.
     * @param GenreRepositoryInterface $genreRepository
     */
    public function __construct(GenreRepositoryInterface $genreRepository)
    {
        $this->genreRepository = $genreRepository;
    }

    /**
     * @param array $attributes
     * @return GenreResource()|bool
     * @throws Exception
     * @throws Throwable
     */
    public function create(array $attributes): GenreResource
    {
        try {
            $category = $this->genreRepository->create($attributes);

            $category = new GenreResource($category);
            return $category;
        } catch (Exception $e) {
            throw $e;
        } catch (Throwable $t) {
            throw $t;
        }
        return false;
    }

    public function all(): AnonymousResourceCollection
    {
        return GenreResource::collection($this->genreRepository->all());
    }

    /**
     * @param $id
     * @return Model
     */
    public function getById($id): GenreResource
    {
        try {
            $model = $this->genreRepository->find($id);
            return new GenreResource($model);
        } catch (Exception $e) {
            throw $e;
        } catch (Throwable $t) {
            throw $t;
        }
    }

    /**
     * @param $id
     * @param $data
     * @return GenreResource()|bool
     * @throws Throwable
     */
    public function update($id, $data): GenreResource
    {
        try {
            $updated = $this->genreRepository->update($id, $data);
            $category = $this->genreRepository->find($id);
            if ($updated) {
                return new GenreResource($category);
            }
        } catch (Exception $e) {
            throw $e;
        } catch (Throwable $t) {
            throw $t;
        }

        return false;
    }


    public function delete($id): bool
    {
        try {
            return $this->genreRepository->delete($id);
        } catch (Exception $e) {
            throw $e;
        } catch (Throwable $t) {
            throw $t;
        }
    }
    /**
     * @param array $attributes
     *
     * @return Model
     */
    public function getTrashed(): AnonymousResourceCollection
    {
        return GenreResource::collection($this->genreRepository->getTrashed());
    }
}
