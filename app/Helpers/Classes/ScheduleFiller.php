<?php

namespace App\Helpers\Classes;

use App\Models\Day;
use App\Models\Group;
use PhpOffice\PhpSpreadsheet\Style\Alignment as StyleAlignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
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
     * Количетсво ячеек(в высоту), занимаемых парой
     */
    private const pairCellCount = 2;

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
        $this->setBoldCell(2, 1);
        $this->setBorderOutline(2, 1);
        $this->sheet->setCellValue('B2', 'пары');
        $this->setBoldCell(2, 2);
        $this->setBorderOutline(2, 2);

        $groups = $this->getGroups();
        foreach($groups as $group) {
            $this->sheet->getColumnDimensionByColumn($startRow)->setWidth(40);
            $this->fillAndCenterCell($startRow, 1, $group['name']);
            $this->setBoldCell($startRow, 1);
            $this->setBorderOutline($startRow, 1);
            $this->sheet->mergeCellsByColumnAndRow($startRow, 1, $startRow + $groupLimit, 1);

            $this->fillAndCenterCell($startRow, 2, 'Дисциплина/преп.');
            $this->setBoldCell($startRow, 2);
            $this->setBorderOutline($startRow,2);
            $this->sheet->mergeCellsByColumnAndRow($startRow, 2, $startRow + $groupLimit - 1, 2);

            $this->sheet->getColumnDimensionByColumn($startRow + $groupLimit)->setWidth(20);
            $this->fillAndCenterCell($startRow + $groupLimit, 2, '№ ауд.');
            $this->setBorderOutline($startRow + $groupLimit,2);
            $this->setBoldCell($startRow + $groupLimit, 2);

            $startRow += $groupLimit + 1;
        }
    }

    /**
     * Сформировать строку с предметом
     * @param mixed $pair
     * @return string
     */
    private function getSubjectRow(mixed $pair): string {
        $result = $pair->subject->name;
        if(isset($pair->additional_info)) {
            $result .= ' '.$pair->additional_info;
        }
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
        $result = $pair->teacher->teacher_position->abbreviated ?? '';
        $result .= ' '.$this->getTeacherNSP($pair->teacher->user ?? $pair->teacher);
        return $result;
    }

    /**
     * Получение строки с аудиторией
     * @param mixed $schedule
     * @return string
     */
    private function getAudienceRow(mixed $schedule): string {
        if(isset($schedule->type) && isset($schedule->type->marker_color)) {
            $richText = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
            $richText->createTextRun('*');
            /*$rt->getFont()
                ->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color($schedule->type->marker_color));*/

            if(isset($schedule->start_date_info)) {
                $richText->createText(' '.$schedule->start_date_info);
            }
            return $richText;
        } else {
            if(isset($schedule->start_date_info)) {
                return $schedule->start_date_info;
            } else return '';
        };
    }

    /**
     * Получение подстроки с аудиторией
     * @param mixed $schedule
     * @return string
     */
    private function getAudienceSubRow(mixed $schedule): string {
        return $schedule->audience->name . ' ауд.';
    }

    /**
     * Устанавливает жирный шрифт ячейки
     * return $this
     */
    private function setBoldCell(int $column, int $row) {
        $this->sheet->getStyleByColumnAndRow($column, $row)->getFont()->setBold(true);
    }

    /**
     * Устанавливает границу на всю ячейку
     * @return void
     */
    private function setBorderOutline(int $column, int $row): void {
        $this->sheet->getStyleByColumnAndRow($column, $row)
            ->getBorders()
            ->getOutline()
            ->setBorderStyle(Border::BORDER_THIN)
            ->setColor(new Color());
    }

    /**
     * Устанавливает границу для дня недели
     * @return void
     */
    private function setDayBorder(int $column, int $row): void {
        $border = $this->sheet->getStyleByColumnAndRow($column, $row)
            ->getBorders();
        $border->getRight()
            ->setBorderStyle(Border::BORDER_THIN)
            ->setColor(new Color());
        $border->getTop()
            ->setBorderStyle(Border::BORDER_THIN)
            ->setColor(new Color());
        $border->getBottom()
            ->setBorderStyle(Border::BORDER_THIN)
            ->setColor(new Color());
    }

    /**
     * Заполняет пары в расписании
     * @return void
     */
    private function fillPairs(): void {
        $startColumn = 3;
        $startRow = 4;
        foreach($this->schedule as $index => $schedule) {
            $pairsPerCell = count(json_decode($schedule['regularity']));
            if($pairsPerCell) {
                for($pairCount = 0; $pairCount < $pairsPerCell; $pairCount++) {
                    $this->fillAndCenterCell(
                        $startColumn,
                        ($startRow * ($index + 1)) + ($schedule['day']['id'] - 1) + (self::pairCellCount * $pairCount),
                        $this->getSubjectRow(json_decode($schedule['regularity'])[$pairCount])
                    );

                    $this->setBoldCell(
                        $startColumn,
                        ($startRow * ($index + 1)) + ($schedule['day']['id'] - 1) + (self::pairCellCount * $pairCount));

                    $this->setBorderOutline($startColumn,
                    ($startRow * ($index + 1)) + ($schedule['day']['id'] - 1) + (self::pairCellCount * $pairCount));

                    $this->fillAndCenterCell(
                        $startColumn,
                        ($startRow * ($index + 1)) + ($schedule['day']['id'] - 1) + 1 + (self::pairCellCount * $pairCount),
                        $this->getTeacherRow(json_decode($schedule['regularity'])[$pairCount])
                    );

                    $this->setBorderOutline($startColumn,
                    ($startRow * ($index + 1)) + ($schedule['day']['id'] - 1) + (self::pairCellCount * $pairCount));

                    $this->fillAndCenterCell(
                        $startColumn + self::pairCellWidthCount,
                        ($startRow * ($index + 1)) + ($schedule['day']['id'] - 1) + 1 + (self::pairCellCount * $pairCount),
                        $this->getAudienceSubRow(json_decode($schedule['regularity'])[$pairCount])
                    );


                    $this->fillAndCenterCell(
                        $startColumn + self::pairCellWidthCount,
                        ($startRow * ($index + 1)) + ($schedule['day']['id'] - 1) + (self::pairCellCount * $pairCount),
                        $this->getAudienceRow(json_decode($schedule['regularity'])[$pairCount])
                    );
                    $this->setBoldCell($startColumn + self::pairCellWidthCount,
                    ($startRow * ($index + 1)) + ($schedule['day']['id'] - 1) + 1 + (self::pairCellCount * $pairCount));
                }
            }

            for($i = 0; $i < self::pairCellHeightCount; $i++) {
                // Установка Border для всех затронутых ячеек
                    $this->setBorderOutline(
                        $startColumn + self::pairCellWidthCount,
                        ($startRow * ($index + 1)) + ($schedule['day']['id'] - 1) + $i
                    );
                    $this->setBorderOutline(
                        $startColumn,
                        ($startRow * ($index + 1)) + ($schedule['day']['id'] - 1) + $i
                    );

                $this->sheet->mergeCellsByColumnAndRow(
                    $startColumn,
                    ($startRow * ($index + 1)) + ($schedule['day']['id'] - 1) + $i,
                    $startColumn + self::pairCellWidthCount - 1,
                    ($startRow * ($index + 1)) + ($schedule['day']['id'] - 1) + $i
                );
            }
        }
    }

    /**
     * Заполняет ячейку согласно строке и столбцу значением value, а также центрирует ее
     * @param int $column
     * @param int $row
     * @param mixed $value
     * @return void
     */
    private function fillAndCenterCell(int $column, int $row, mixed $value) {
        $this->sheet->setCellValueByColumnAndRow(
            $column,
            $row,
            $value
        )
        ->getStyleByColumnAndRow($column, $row)
        ->getAlignment()->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);
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
                $this->setBorderOutline(2, $pairStart);
            }

            $pairStart += 1;


            $this->sheet->mergeCellsByColumnAndRow(
                1,
                $startRow + 1,
                1,
                $startRow + (self::pairCount * self::pairCellHeightCount));
            $this->setDayBorder(1, $startRow + 1);

            $this->sheet
            ->setCellValueByColumnAndRow(1, $startRow + 1, $day['name'])
            ->getStyleByColumnAndRow(1, $startRow + 1)
            ->getAlignment()
            ->setTextRotation(-90)
            ->setVertical(StyleAlignment::VERTICAL_CENTER)
            ->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);
            $this->setBoldCell(1, $startRow + 1);

            $startRow += (self::pairCount * self::pairCellHeightCount) + 1;
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
