<?php

namespace App\Helpers\Enums;

use App\Helpers\Traits\EnumHelper;

//TODO: ?парсинг новостей с рфпгу, со старого или нового сайта

enum NewsCategories: string {
    use EnumHelper;

    case CATEGORY_STUDY = 'Учеба';
    case CATEGORY_SCIENCE = 'Наука';
    case CATEGORY_ENROLLEE = 'Абитуриент';
    case CATEGORY_NEWS = 'Новости';
    case CATEGORY_GROUP_NEWS = 'Новости группы';
    case CATEGORY_UNIVERSITY = 'РФ ПГУ';
    case CATEGORY_INEWS = 'И-новости';
    case CATEGORY_ADVERTISEMENTS = 'Обявления';
}
