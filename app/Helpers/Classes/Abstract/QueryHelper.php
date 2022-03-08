<?php
namespace App\Helpers\Classes\Abstract;

use Illuminate\Database\Eloquent\Builder;

abstract class QueryHelper {
    /**
     * Фильтрация исходных данных по идентификатору $name
     * @param string $name
     * @return self
     */
    abstract public function query(string $name): self;

    /**
     * @param Illuminate\Database\Eloquent\Builder $query
     * Экземпляр базового запроса, который затем перебирается в цикле
     * @param string $name
     * Имя запрашиваемого параметра фильтра
     * @param string $key
     * Ключ фильтрации
     * @param mixed $dataPart
     * Объект данных в массиве
     */
    abstract protected function baseQuery(Builder $query, string $name, string $key, mixed $dataPart): void;


    /**
     * Вернуть экземпляр построителя запросов после проделанных операций
     * @return Builder
     */
    abstract public function getBuilder(): Builder;
}
