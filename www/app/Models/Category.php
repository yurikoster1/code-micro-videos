<?php

namespace App\Models;

use App\Traits\Models\UsesUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes, UsesUuid;

    protected $fillable = ['name',
        'description',
        'is_active'
    ];

    public function getIsActiveAttribute($value)
    {
        return $value == 1 ? true : false;
    }

}
