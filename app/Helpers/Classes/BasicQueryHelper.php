<?php
namespace App\Helpers\Classes;

use App\Helpers\Classes\Abstract\QueryHelper;
use Illuminate\Database\Eloquent\Builder;

class BasicQueryHelper extends QueryHelper {
    protected static Builder $query;
    protected array $data;
    protected static Pluralizer $pluralizer;
    protected static array $map;

    public function __construct(Builder $query, array $data) {
        self::$query = $query;
        $this->data = $data;
        self::$pluralizer = new Pluralizer();
        self::$map = [];
    }
    public function query(string $name): self {
        self::$query->when(isset($this->data[$name]), function (Builder $query) use ($name) {
            foreach($this->data[$name] as $key => $dataPart) {
                $this->baseQuery($query, $name, $key, $dataPart);
            }
        });
        return $this;
    }
    protected function baseQuery(Builder $query, string $name, string $key, mixed $dataPart): void {
        $this->fillQueryMap($name, $key, $dataPart);
    }

    protected static function prepareQuery(): void {
        foreach(static::$map as $filterProperty) {
            foreach($filterProperty as $filterKey => $filterValue) {
                static::$query->whereIn($filterKey, $filterValue);
            }
        }
    }

    protected function fillQueryMap(string $name, string $key, mixed $dataPart): void {
        $queryPropertyEntries = $this->map[$name][self::getQueryParamString($name, $key)];
        if(isset($queryPropertyEntries) && count($queryPropertyEntries)) {
            array_push($queryPropertyEntries, $dataPart);
        } else $queryPropertyEntries = array($dataPart);
    }

    protected static function getQueryParamString(string $name, ?string $key): string {
        return self::$pluralizer->apluralize($name).'_'.$key;
    }

    public function getBuilder(): Builder {
        static::prepareQuery();
        return self::$query;
    }
}
