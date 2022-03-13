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
     * Вернуть экземпляр построителя запросов после проделанных операций
     * @return Builder
     */
    abstract public function getBuilder(): Builder;
}
