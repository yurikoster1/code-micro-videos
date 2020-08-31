<?php

namespace App\Http\Requests\Category\v1;

use App\Http\Requests\Category\Interfaces\CategoryStoreRequestInterface;

class CategoryStoreRequest extends CategoryBaseRequest implements CategoryStoreRequestInterface
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
            'name' => ['unique:categories']
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
