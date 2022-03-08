<?php
namespace App\Helpers\Traits;

trait QueryHelperTrait {
    protected static function getRelatedParentName(string $relationName): string {
        return substr($relationName, 0, stripos($relationName, '_'));
    }

    protected static function getRelatedChildName(string $relationName): string {
        return substr($relationName, stripos($relationName, '_') + 1);
    }

    protected static function getPluralRelationName(string $relationName, string $separator): string {
        $parent = self::getRelatedParentName($relationName);
        return parent::$pluralizer->pluralize($parent).$separator.self::getRelatedChildName($relationName);
    }
}
