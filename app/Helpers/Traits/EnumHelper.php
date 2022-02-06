<?php

namespace App\Helpers\Traits;


trait EnumHelper {

    public static function getNames(array $entities)
    {
        return array_column($entities, 'name');
    }

    public static function getValues(array $entities)
    {
        return array_column($entities, 'value');
    }
}
