<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subjects = 
        [
            [
                'name' => 'История ПМР'
            ],
            [
                'name' => 'Программирование'
            ],
            [
                'name' => 'Интегралы и дефференцифльные уравнения'
            ],
            [
                'name' => 'Иностранный язык'
            ],
            [
                'name' => 'Физика'
            ],
            [
                'name' => 'Логика и теория алгоритмов'
            ],
            [
                'name' => 'Основы web-технологий'
            ],
            [
                'name' => 'Элективные курсы по физической культуре'
            ],
            [
                'name' => 'Теоретическая информатика'
            ],
            [
                'name' => 'Математический анализ'
            ],
            [
                'name' => 'Математика'
            ],
            [
                'name' => 'Педагогика'
            ],
            [
                'name' => 'Общая психология'
            ],
            [
                'name' => 'Философия'
            ],
            [
                'name' => 'Дискретная математика'
            ],
            [
                'name' => 'Основы политического вл. ПМР'
            ],
            [
                'name' => 'Основы полит-кой власти ПМР'
            ],
            [
                'name' => 'Теория вероятн. и матем. статист.'
            ],
            [
                'name' => 'Прикладная математика'
            ],
            [
                'name' => 'Численные методы'
            ],
            [
                'name' => 'Объектно-ориентированное программирование'
            ],
            [
                'name' => 'Методы и средства защиты информации'
            ],
            [
                'name' => 'Организация и управление педагогич-ми системами'
            ],
            [
                'name' => 'Современные технологии инключивного образов.'
            ],
            [
                'name' => 'История педагогики и образования'
            ],
            [
                'name' => 'Мировые информационные ресурсы'
            ],
            [
                'name' => 'Переферийные устройства ЭВМ'
            ],
            [
                'name' => 'Базы данных'
            ],
            [
                'name' => 'Машино-зависимые языки программирования'
            ],
            [
                'name' => 'Операционные системы'
            ],
            [
                'name' => 'Архитектура ЭВМ'
            ],
            [
                'name' => 'Моделирование'
            ],
            [
                'name' => 'Математ. обработка результатов педаг. исслед.'
            ],
            [
                'name' => 'Методика обучения и воспитания'
            ],
            [
                'name' => 'Программное обеспечение ЭВМ'
            ],
            [
                'name' => 'Метрология, стандарт. и сертифик. в инфокоммуник.'
            ],
            [
                'name' => 'Основы искуственного интелекта'
            ],
            [
                'name' => 'Компьютерная графика'
            ],
            [
                'name' => 'Проектирование программного обеспечения'
            ],
            [
                'name' => 'Экономика программной инженерии'
            ],
            [
                'name' => 'Логическое и функцион-ое программирование'
            ],
            [
                'name' => 'ИКТ в образовании'
            ],
            [
                'name' => 'Экономико-правовые основы рынка прогр.обесп'
            ],
            [
                'name' => 'Информационно-коммуник. технол. в образов.'
            ],
        ];

        foreach ($subjects as $subject) {
            Subject::create([
                'name' => $subject['name'],
            ]);
        }
    }
}
