<?php
namespace App\Helpers\Enums;

use App\Helpers\Traits\EnumHelper;

enum PaymentForms: string {
    use EnumHelper;


    case PAYMENT_BUDGET = 'бюджет';
    case PAYMENT_CONTRACT = 'договор';
}
