<?php

namespace Database\Seeders;

use App\Helpers\Enums\PaymentForms;
use App\Models\PaymentForm;
use Illuminate\Database\Seeder;

class PaymentFormSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach(PaymentForms::getValues(PaymentForms::cases()) as $studyFormName) {
            PaymentForm::create([
                'name' => $studyFormName
            ]);
        }
    }
}
