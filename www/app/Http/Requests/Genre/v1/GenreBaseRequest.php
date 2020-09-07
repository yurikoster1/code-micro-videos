<?php

namespace App\Http\Requests\Genre\v1;

use App\Http\Requests\BaseRequest;

class GenreBaseRequest extends BaseRequest
{
    public const NAME_MAX_LENGTH = 255;
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
            'name' => ['required', 'max:'.$this::NAME_MAX_LENGTH],
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
            'is_active' => ['casts:boolean']
        ];
    }
}
