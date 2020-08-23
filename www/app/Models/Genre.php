<?php

namespace App\Models;

use App\Traits\Models\UsesUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Genre extends Model
{
    use SoftDeletes, UsesUuid;

    protected $fillable = [
        'name',
        'is_active'
    ];
    public function getIsActiveAttribute($value)
    {
        return $value == 1 ? true : false;
    }
}
