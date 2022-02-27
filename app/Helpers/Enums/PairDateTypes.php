<?php
namespace App\Helpers\Enums;

use App\Helpers\Traits\EnumHelper;

enum PairDateTypes: string {
    use EnumHelper;

    case TYPE_EVEN = 'Четная неделя';
    case TYPE_ODD = 'Нечетная неделя';
}
