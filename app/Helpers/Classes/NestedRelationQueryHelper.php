<?php
namespace App\Helpers\Classes;

use App\Helpers\Traits\QueryHelperTrait;
use Illuminate\Database\Eloquent\Builder;
use RecursiveArrayIterator;
use RecursiveIteratorIterator;

class NestedRelationQueryHelper extends BasicQueryHelper {
    use QueryHelperTrait;

    protected static $allowedFilterFields = [
        'pair_subject' => ['id'],
        'pair_type' => ['id'],
        'pair_teacher' => ['id'],
        'pair_number' => ['start', 'end', 'number'],
    ];

    protected static $nonRelationFields = ['pair_number'];

    protected static $relationSeparator = '.';

    public function __construct(Builder $query, array $data) {
        parent::__construct($query, $data);
    }
    protected static function prepareQuery(): void {
        foreach(parent::$map as $filterProperties) {
            foreach($filterProperties as $propertyName => $filterProperty) {
                foreach($filterProperty as $key => $value) {
                    if(isset(static::$allowedFilterFields[$propertyName]) && in_array($key, static::$allowedFilterFields[$propertyName])) {
                        if(is_string($key)) {
                            $relation = self::getPluralRelationName($propertyName, self::$relationSeparator);
                            if(in_array($propertyName, self::$nonRelationFields)) {
                                parent::$query->whereHas(self::camelize($propertyName), function (Builder $q) use ($key, $value) {
                                    $q->whereIn($key, ...array_values($value));
                                });
                            } else {
                                parent::$query->whereHas($relation, function (Builder $q) use ($key, $value) {
                                    $q->whereIn($key, $value);
                                });
                            }
                        }
                    } else {
                        if(!is_string($key)) {
                            $directRelation = static::getRelatedParentName($propertyName);
                            parent::$query->whereHas(parent::$pluralizer->pluralize($directRelation), function($q) use ($propertyName, $filterProperty) {
                                $q->whereIn(self::getRelatedChildName($propertyName), $filterProperty);
                            });
                        } else
                        throw new \Error("Фильтрация по полю $key невозможна");
                    }
                }
            }
        }
    }

    public function fillQueryMap(string $name, string $key, mixed $dataPart): void {
        if(isset(static::$map[$name][parent::$pluralizer->apluralize($name)][$key])
        &&
        count(static::$map[$name][parent::$pluralizer->apluralize($name)][$key])) {
            array_push($this->map[$name][parent::$pluralizer->apluralize($name)][$key], $dataPart);
        } else static::$map[$name][parent::$pluralizer->apluralize($name)][$key] = array($dataPart);
    }

    protected static function getQueryParamString(string $name, ?string $key): string {
        return str_replace('_', static::$relationSeparator, parent::$pluralizer->apluralize($name));
    }
}
