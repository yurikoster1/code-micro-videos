<?php

namespace App\Http\Requests\Genre\v1;

use App\Http\Requests\Genre\Interfaces\GenreUpdateRequestInterface;

class GenreUpdateRequest extends GenreBaseRequest implements GenreUpdateRequestInterface
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
        $rules= [

        ];
        return array_merge_recursive(parent::rules(), $rules);
    }
}
