<?php
namespace App\Helpers\Classes;

use App\Helpers\Classes\Abstract\QueryHelper;
use Illuminate\Database\Eloquent\Builder;
class BasicQueryHelper extends QueryHelper {
    protected static $allowedFilterFields = [
        'days' => ['id'],
        'groups' => ['id'],
    ];
    protected static Builder $query;
    protected array $data;
    protected static Pluralizer $pluralizer;
    protected static array $map;

    public function __construct(Builder $query, array $data) {
        $this->data = $data;
        self::$query = $query;
        self::$pluralizer = new Pluralizer();
        self::$map = [];
    }
    public function query(string $name): self {
        self::$query->when(isset($this->data[$name]), function (Builder $query) use ($name) {
            foreach($this->data[$name] as $key => $dataPart) {
                $this->fillQueryMap($name, $key, $dataPart);
            }
        });
        return $this;
    }

    protected static function prepareQuery(): void {
        foreach(static::$map as $filterProperty) {
            foreach($filterProperty as $filterKey => $filterValue) {
                static::$query->whereIn($filterKey, $filterValue);
            }
        }
    }

    protected function fillQueryMap(string $name, string $key, mixed $dataPart): void {
        if(in_array($key,self::$allowedFilterFields[$name])) {
            if(isset(self::$map[$name][self::getQueryParamString($name, $key)])) {
                array_push(self::$map[$name][self::getQueryParamString($name, $key)], $dataPart);
            } else self::$map[$name][self::getQueryParamString($name, $key)] = array($dataPart);
        } else {
            throw new \Error("Фильтрация по полю $key невозможна");
        }
    }

    protected static function getQueryParamString(string $name, ?string $key): string {
        return self::$pluralizer->apluralize($name).'_'.$key;
    }

    public function getBuilder(): Builder {
        static::prepareQuery();
        return self::$query;
    }
}
