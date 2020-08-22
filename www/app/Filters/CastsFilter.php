<?php


namespace App\Filters;

use Illuminate\Support\Collection;
use InvalidArgumentException;
use Waavi\Sanitizer\Filters\Cast;


class CastsFilter extends  Cast
{

    public function apply($value, $options = [])
    {
        $type = isset($options[0]) ? $options[0] : null;
        switch ($type) {
            case 'int':
            case 'integer':
                return (int)$value;
            case 'real':
            case 'float':
            case 'double':
                return (float)$value;
            case 'string':
                return (string)$value;
            case 'bool':
            case 'boolean':
                return  ($value === null || $value === '') ? null :  filter_var($value, FILTER_VALIDATE_BOOLEAN,FILTER_NULL_ON_FAILURE);
            case 'object':
                return is_array($value) ? (object)$value : json_decode($value, false);
            case 'array':
                return json_decode($value, true);
            case 'collection':
                $array = is_array($value) ? $value : json_decode($value, true);
                return new Collection($array);
            default:
                throw new InvalidArgumentException("Wrong Sanitizer casting format: {$type}.");
        }
    }
}
