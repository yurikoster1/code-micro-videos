<?php


namespace App\Http\Requests\Genre\Interfaces;

interface GenreStoreRequestInterface
{
    public function rules() : array;

    public function filters() ;
}
