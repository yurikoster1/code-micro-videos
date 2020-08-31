<?php

namespace App\Models;

use App\Models\Base\BaseModel;
use App\Traits\Models\Activatable;
use App\Traits\Models\UsesUuid;
use Illuminate\Database\Eloquent\SoftDeletes;

class Genre extends BaseModel
{
    use SoftDeletes, UsesUuid, Activatable;

    protected $fillable = [
        'name'
    ];
    public function getIsActiveAttribute($value)
    {
        return $value == 1 ? true : false;
    }
}
