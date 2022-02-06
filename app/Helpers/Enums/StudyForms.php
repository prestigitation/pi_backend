<?php
namespace App\Helpers\Enums;

use App\Helpers\Traits\EnumHelper;

enum StudyForms: string {
    use EnumHelper;

    case FORM_UNDERGRADUATE = 'Бакалавриат';
    case FORM_MAGISTRACY = 'Магистратура';
    case FORM_POSTGRADUATE = 'Аспирантура';
}
