<?php

namespace App\Repositories;

use App\Models\PaymentForm;

class PaymentFormRepository
{
    public function getAll()
    {
        return PaymentForm::all();
    }
}
