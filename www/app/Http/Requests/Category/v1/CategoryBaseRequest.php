<?php

namespace App\Http\Requests\Category\v1;

use App\Http\Requests\BaseRequest;

class CategoryBaseRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'max:255'],
            'is_active' => 'boolean'
        ];
    }

    /**
     * @return string[]
     */
    public function filters()
    {
        return [
            'name'  => ['trim','capitalize', 'escape'],
            'description' => ['trim', 'escape'],
            'is_active' => ['casts:boolean']
        ];
    }
}
