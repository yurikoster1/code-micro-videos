<?php

namespace App\Http\Requests\Genre\v1;

use App\Http\Requests\Genre\Interfaces\GenreStoreRequestInterface;

class GenreStoreRequest extends GenreBaseRequest implements GenreStoreRequestInterface
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $rules = [
            'name' => ['unique:genres']
        ];
        return array_merge_recursive(parent::rules(), $rules);
    }

    /**
     * @return string[]
     */
    public function filters()
    {
        $filters = [];
        return array_merge(parent::filters(), $filters);

    }
}
