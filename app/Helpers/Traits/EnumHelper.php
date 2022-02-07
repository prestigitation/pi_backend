<?php

namespace App\Helpers\Traits;

use Illuminate\Database\Eloquent\Model;
use stdClass;

trait EnumHelper {

    public static function getNames(array $entities)
    {
        return array_column($entities, 'name');
    }

    public static function getValues(array $entities)
    {
        return array_column($entities, 'value');
    }

    /**
     * Получить модель из перечисления на основе имени модели и поля 'name'
     *
     * @return Eloquent $model
     */
    public static function getEnumModel(mixed $model, mixed $nameValue)
    {
        return $model::where('name', $nameValue->value)->first();
    }
}
