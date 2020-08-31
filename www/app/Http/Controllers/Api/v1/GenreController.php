<?php

namespace App\Http\Controllers\Api\v1;

use App;
use App\Http\Controllers\Controller;
use App\Http\Requests\Genre\Interfaces\GenreStoreRequestInterface;
use App\Http\Requests\Genre\Interfaces\GenreUpdateRequestInterface;
use App\Http\Requests\Genre\v1\GenreStoreRequest;
use App\Http\Requests\Genre\v1\GenreUpdateRequest;
use App\Repository\Interfaces\GenreRepositoryInterface;
use App\Services\Interfaces\GenreServiceInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class GenreController extends Controller
{
    private $genreRepository;
    private $genreService;
    public function __construct(GenreRepositoryInterface $genreRepository, GenreServiceInterface $genreService)
    {
        $this->genreRepository = $genreRepository;
        $this->genreService = $genreService;
        App::bind(GenreStoreRequestInterface::class, GenreStoreRequest::class);
        App::bind(GenreUpdateRequestInterface::class, GenreUpdateRequest::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->success($this->genreRepository->all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(GenreStoreRequestInterface $request)
    {
        $genre = $this->genreService->create($request->validated());
        return  response()->success($genre);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Genre  $genre
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($genre)
    {
        try {
            $genre = $this->genreService->getById($genre);
        } catch (ModelNotFoundException $e) {
            return response()->error('Model not Found', 404);
            ;
        }
        return  response()->success($genre);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Genre  $genre
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(GenreUpdateRequestInterface $request, $genre)
    {
        try {
            $genre = $this->genreService->update($genre, $request->validated());
        } catch (ModelNotFoundException $e) {
            return response()->error('Model not Found', 404);
            ;
        }
        return response()->success($genre);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Genre  $genre
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function destroy($genre)
    {
        try {
            $this->genreService->delete($genre);
        } catch (ModelNotFoundException $e) {
            return response()->error('Model not Found', 404);
            ;
        }
        return response()->noContent();
    }
}
