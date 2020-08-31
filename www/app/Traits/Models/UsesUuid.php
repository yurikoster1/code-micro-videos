<?php
namespace App\Traits\Models;

use Illuminate\Support\Str;

trait UsesUuid
{
    protected function initializeUsesUuid()
    {
        if (!isset($this->casts['id'])) {
            $this->casts['id']  =  'string';
        }
        if ($this->incrementing) {
            $this->incrementing = false;
        }
    }
    protected static function bootUsesUuid()
    {
        static::creating(function ($model) {
            if (! $model->getKey()) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    public function getIncrementing()
    {
        return false;
    }

    public function getKeyType()
    {
        return 'string';
    }
}
