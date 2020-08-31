<?php


namespace App\Http\Requests\Genre\Interfaces;

interface GenreUpdateRequestInterface
{
    public function rules(): array;

    public function filters();
}
