<?php

namespace App\Services;

use App\Http\Resources\CategoryResource;
use App\Repository\Interfaces\CategoryRepositoryInterface;
use App\Services\Interfaces\CategoryServiceInterface;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Throwable;

class CategoryService implements CategoryServiceInterface
{
    private $categoryRepository;

    /**
     * CategoryService constructor.
     * @param CategoryRepositoryInterface $categoryRepository
     */
    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @param array $attributes
     * @return CategoryResource|bool
     * @throws Exception
     * @throws Throwable
     */
    public function create(array $attributes): CategoryResource
    {
        try {
            $category = $this->categoryRepository->create($attributes);
            $category = new CategoryResource($category);
            return $category;
        } catch (Exception $e) {
            throw $e;
        } catch (Throwable $t) {
            throw $t;
        }
    }

    public function all(): AnonymousResourceCollection
    {
        return CategoryResource::collection($this->categoryRepository->all());
    }

    /**
     * @param $id
     * @return Model
     */
    public function getById($id): CategoryResource
    {
        try {
            $model = $this->categoryRepository->find($id);
            return new CategoryResource($model);
        } catch (Exception $e) {
            throw $e;
        } catch (Throwable $t) {
            throw $t;
        }
    }

    /**
     * @param $id
     * @param $data
     * @return CategoryResource|bool
     * @throws Throwable
     */
    public function update($id, $data): CategoryResource
    {
        try {
            $updated = $this->categoryRepository->update($id, $data);
            $category = $this->categoryRepository->find($id);
            if ($updated) {
                return new CategoryResource($category);
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
            return $this->categoryRepository->delete($id);
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
        return CategoryResource::collection($this->categoryRepository->getTrashed());
    }
}
