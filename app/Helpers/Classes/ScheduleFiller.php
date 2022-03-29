<?php

namespace App\Helpers\Classes;

use App\Models\Day;
use App\Models\Group;
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

    /**
     * Записи расписания
     */
    private $schedule;

    public function __construct(Worksheet $sheet, array $schedule) {
        $this->sheet = $sheet;
        $this->schedule = $schedule;
    }

    /**
     * Заполняет excel таблицу
     * @return void
     */
    public function fillSchedule(): void {
        $this->fillHeader();
        $this->fillDays();
        $this->fillPairs();
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
     * Сформировать строку с предметом
     * @param $pair
     * @return string
     */
    private function getSubjectRow($pair): string {
        $result = '';
        if(isset($pair->start_date_info)) {
            $result .= $pair->start_date_info . ' ';
        }
        $result .= $pair->subject->name;
        return $result;
    }

    /**
     * Сформировать инициалы преподавателя для внесения в расписание
     * @return string
     */
    private function getTeacherNSP($teacher): string {
        return
        ucfirst($teacher->surname ?? $teacher->user->surname).' '.
        mb_substr(ucfirst($teacher->name ?? $teacher->user->name), 0, 1).'.'.
        mb_substr(ucfirst($teacher->patronymic ?? $teacher->user->patronymic), 0, 1);
    }

    /**
     * Сформировать строку преподавателя
     * @param $pair
     * @return string
     */
    private function getTeacherRow($pair): string {
        $result = $pair->teacher->teacher_position->abbreviated;
        $result .= ' '.$this->getTeacherNSP($pair->teacher->user ?? $pair->teacher);
        if(isset($pair->additional_info)) {
            $result .= $pair->additional_info;
        }
        return $result;
    }

    /**
     * Заполняет пары в расписании
     * @return void
     */
    private function fillPairs(): void {
        $startColumn = 3;
        $startRow = 4;
        foreach($this->schedule as $schedule) {
            if(count(json_decode($schedule['regularity'])) === 1) {
                $this->sheet->setCellValueByColumnAndRow(
                    $startColumn,
                    $startRow * $schedule['pair_number']['number'] + 1,
                    $this->getSubjectRow(json_decode($schedule['regularity'])[0])
                );
                $this->sheet->setCellValueByColumnAndRow(
                    $startColumn,
                    $startRow * $schedule['pair_number']['number'] + 2,
                    $this->getTeacherRow(json_decode($schedule['regularity'])[0])
                );
                for($i = 0; $i < self::pairCellHeightCount; $i++) {
                    $this->sheet->mergeCellsByColumnAndRow(
                        $startColumn,
                        ($startRow * $schedule['pair_number']['number']) + $i,
                        $startColumn + self::pairCellWidthCount - 1,
                        ($startRow * $schedule['pair_number']['number']) + $i
                    );
                }
            }
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
            $this->sheet->setCellValueByColumnAndRow(1, $startRow, $day['study_process']['name']);


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
                (self::pairCount * self::pairCellHeightCount) * ($index + 1));
            $this->sheet->setCellValueByColumnAndRow(1, $startRow + 1, $day['name']);
            $startRow = (self::pairCount * self::pairCellHeightCount) * ($index + 1) + 1;
        }
    }


    /**
     * Метод для получения всех групп
     * @return array
     */
    private function getGroups(): array {
        return Group::all()->toArray();
    }

    /**
     * Метод для получения дней недели
     * @return array
     */
    private function getDays() {
        return Day::all()->toArray();
    }
}
