<?php

namespace App\Providers;

use App\Services\CategoryService;
use App\Services\GenreService;
use App\Services\Interfaces\CategoryServiceInterface;
use App\Services\Interfaces\GenreServiceInterface;
use Illuminate\Support\ServiceProvider;
use App\Repository\Eloquent\BaseRepository;
use App\Repository\Eloquent\CategoryRepository;
use App\Repository\Eloquent\GenreRepository;
use App\Repository\Interfaces\CategoryRepositoryInterface;
use App\Repository\Interfaces\EloquentRepositoryInterface;
use App\Repository\Interfaces\GenreRepositoryInterface;

/**
 * Class RepositoryServiceProvider
 * @package App\Providers
 */
class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(EloquentRepositoryInterface::class, BaseRepository::class);
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(CategoryServiceInterface::class, CategoryService::class);
        $this->app->bind(GenreRepositoryInterface::class, GenreRepository::class);
        $this->app->bind(GenreServiceInterface::class, GenreService::class);
    }
}
