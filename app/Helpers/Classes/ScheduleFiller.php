<?php

namespace App\Helpers\Classes;

use \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ScheduleFiller {
    /**
     * Количество ячеек, выделяющихся на один пункт в расписании (по высоте)
     */
    private const pairCellHeightCount = 4;

    /**
     * Количество ячеек, выделяющихся на один пункт в расписании (по ширине)
     */
    private const pairCellWidthCount = 3;

    /**
     * Количество пар в 1 учебном дне
     */
    private const pairCount = 5;

    /**
     * Инстанс Worksheet, для манипуляций с таблицей Excel
     */
    private $sheet;

    public function __construct(Worksheet $sheet) {
        $this->sheet = $sheet;
    }

    /**
     * Заполняет excel таблицу
     * @return void
     */
    public function fillSchedule(): void {
        $this->fillHeader();
        $this->fillDays();
    }

    /**
     * Заполнить хэдер таблицы
     * @return void
     */
    private function fillHeader(): void {
        $groupLimit = 3;
        $startRow = 3;

        $this->sheet->setCellValue('B1', '№');
        $this->sheet->setCellValue('B2', 'пары');

        $groups = $this->getGroups();
        foreach($groups as $group) {
            $this->sheet->setCellValueByColumnAndRow($startRow, 1, $group['name']);
            $this->sheet->mergeCellsByColumnAndRow($startRow, 1, $startRow + $groupLimit, 1);

            $this->sheet->setCellValueByColumnAndRow($startRow, 2, 'Дисциплина/преп.');
            $this->sheet->mergeCellsByColumnAndRow($startRow, 2, $startRow + $groupLimit - 1, 2);
            $this->sheet->setCellValueByColumnAndRow($startRow + $groupLimit, 2, '№ ауд.');

            $startRow += $groupLimit + 1;
        }
    }

    /**
     * Заполняет дни недели, а также формат обучения и номера пар
     * @return void
     */
    private function fillDays(): void {
        $startRow = 3;
        $pairStart = 4;
        $groupCount = count($this->getGroups());
        foreach($this->getDays() as $index => $day) {
            $this->sheet->mergeCellsByColumnAndRow(
                1,
                $startRow,
                self::pairCellWidthCount * $groupCount + self::pairCellWidthCount - 1,
                $startRow);
            $this->sheet->setCellValueByColumnAndRow(1, $startRow, $day['type']);


            for($pairIndex = 1; $pairIndex <= self::pairCount; $pairIndex++) {
                $this->sheet->setCellValueByColumnAndRow(2, $pairStart, $pairIndex);
                $this->sheet->mergeCellsByColumnAndRow(
                    2,
                    $pairStart,
                    2,
                    $pairStart + self::pairCellHeightCount - 1
                    );
                    $pairStart += self::pairCellHeightCount;
            }

            $pairStart += 1;


            $this->sheet->mergeCellsByColumnAndRow(
                1,
                $startRow + 1,
                1,
                (self::pairCount * self::pairCellHeightCount) + $startRow);
            $this->sheet->setCellValueByColumnAndRow(1, $startRow + 1, $day['name']);
            $startRow += (self::pairCount * self::pairCellHeightCount) * ($index + 1) + 1;
        }
    }


    /**
     * Метод для получения всех групп
     * @return array
     */
    private function getGroups(): array {
        return [[
            'name' => 'РФ16ДР62ПИ'
        ],
        [
            'name' => 'РФ16ДР62ПИ'
        ],
        [
            'name' => 'РФ16ДР62ПИ'
        ],
        [
            'name' => 'РФ16ДР62ПИ'
        ],
        [
            'name' => 'РФ16ДР62ПИ'
        ],
        [
            'name' => 'РФ16ДР62ПИ'
        ],
        [
            'name' => 'РФ16ДР62ПИ'
        ],
        [
            'name' => 'РФ16ДР62ПИ'
        ]];
    }

    private function getDays() {
        return [
            [
                'name' => 'Понедельник',
                'type' => 'ДИСТАНЦИОННОЕ ОБУЧЕНИЕ'
            ],
            [
                'name' => 'Вторник',
                'type' => 'АУДИТОРНОЕ ОБУЧЕНИЕ'
            ],
        ];
    }
}
