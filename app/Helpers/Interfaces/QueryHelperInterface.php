<?php
namespace App\Helpers\Interfaces;

use Illuminate\Database\Eloquent\Builder;

interface QueryHelperInterface {
    /**
     * Фильтрация исходных данных по идентификатору $name
     * @param string $name
     * @return self
     */
    public function query(string $name): self;

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
    public function baseQuery(Builder $query, string $name, string $key, mixed $dataPart): void;
}
