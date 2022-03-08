<?php
namespace App\Helpers\Classes;

class Pluralizer {
    /**
     * Функция получения единственного числа в строке(если строка оканчивается на s)
     * @return string
     * @throws \Exception
     * Исключение, выброшенное если строка не представлена во множ.числе
     */
    function apluralize(string $str): string {
        if(str_ends_with($str, 's')) {
            return substr($str,0,-1);
        } else throw new \Exception("Переданная строка($str) не представлена во множественном числе!");
    }

    function pluralize(string $str): string {
        return $str.'s';
    }
}
