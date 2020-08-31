<?php


namespace App\Traits\Models;

trait Activatable
{
    public function initializeActivatable()
    {
        if (!in_array('is_active', $this->getFillable(), true)) {
            $this->fillable[] =  'is_active';
        }
    }

    public function getIsActiveAttribute($value)
    {
        return $value == 1 ? true : false;
    }
}
