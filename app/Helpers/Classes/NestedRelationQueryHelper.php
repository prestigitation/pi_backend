<?php
namespace App\Helpers\Classes;

use Illuminate\Database\Eloquent\Builder;

class NestedRelationQueryHelper extends BasicQueryHelper {
    protected static $relationSeparator = '.';

    public function __construct(Builder $query, array $data) {
        parent::__construct($query, $data);
    }
    protected static function prepareQuery(): void {
        foreach(parent::$map as $filterProperties) {
            foreach($filterProperties as $propertyName => $filterProperty) {
                foreach($filterProperty as $key => $value) {
                    if(is_string($key)) {
                        $relation = self::getPluralRelationName($propertyName);
                        parent::$query->whereHas($relation, function (Builder $q) use ($key, $value) {
                            $q->whereIn($key, $value);
                        });
                    } else {
                        $directRelation = static::getRelatedParentName($propertyName);
                        parent::$query->whereRelation(parent::$pluralizer->pluralize($directRelation), self::getRelatedChildName($propertyName), $value);
                    }
                }
            }
        }
    }

    public function fillQueryMap(string $name, string $key, mixed $dataPart): void {
        if(isset(static::$map[$name][parent::$pluralizer->apluralize($name)][$key])
        &&
        count($this->map[$name][parent::$pluralizer->apluralize($name)][$key]) > 0) {
            array_push($this->map[$name][parent::$pluralizer->apluralize($name)][$key], $dataPart);
        } else static::$map[$name][parent::$pluralizer->apluralize($name)][$key] = array($dataPart);
    }

    protected static function getQueryParamString(string $name, ?string $key): string {
        return str_replace('_', static::$relationSeparator, parent::$pluralizer->apluralize($name));
    }

    protected static function getRelatedParentName(string $relationName): string {
        return substr($relationName, 0, stripos($relationName, '_'));
    }

    protected static function getRelatedChildName(string $relationName): string {
        return substr($relationName, stripos($relationName, '_') + 1);
    }

    protected static function getPluralRelationName(string $relationName): string {
        $parent = self::getRelatedParentName($relationName);
        return parent::$pluralizer->pluralize($parent).self::$relationSeparator.self::getRelatedChildName($relationName);
    }
}
