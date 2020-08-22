<?php

namespace App\Services;

use App\Http\Resources\CategoryResource;
use App\Repository\Interfaces\CategoryRepositoryInterface;
use App\Services\Interfaces\CategoryServiceInterface;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;
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
        return false;
    }

    public function all(): Collection
    {
        return CategoryResource::collection($this->categoryRepository->all());
    }

    /**
     * @param $id
     * @return Model
     */
    public function getById($id): Model
    {
        try {
            $model = $this->categoryRepository->find($id);
        } catch (Exception $e) {
            throw $e;
        } catch (Throwable $t) {
            throw $t;
        }
        return $model;
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
}
