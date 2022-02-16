<?php

namespace Database\Seeders;

use App\Helpers\Enums\PaymentForms;
use App\Helpers\Traits\EnumHelper;
use App\Helpers\Enums\Profiles;
use App\Helpers\Enums\Specialities;
use App\Helpers\Enums\StudyForms;
use App\Helpers\Enums\TimeForms;
use App\Models\Direction;
use App\Models\PaymentForm;
use App\Models\Profile;
use App\Models\Speciality;
use App\Models\StudyForm;
use App\Models\TimeForm;
use App\Repositories\StudyVariantRepository;
use Illuminate\Database\Seeder;

class DirectionSeeder extends Seeder
{
    private $studyVariantRepository;

    public function __construct(studyVariantRepository $studyVariantRepository)
    {
        $this->studyVariantRepository = $studyVariantRepository;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $budget = PaymentForm::where('name', PaymentForms::PAYMENT_BUDGET)->first()->id;
        $contract = PaymentForm::where('name', PaymentForms::PAYMENT_CONTRACT)->first()->id;

        $fullTime = TimeForm::where('name', TimeForms::TIME_FULL->value)->first()->id;
        $distance = TimeForm::where('name', TimeForms::TIME_DISTANCE->value)->first()->id;



        $directions = [
            [
                'code' => '6.44.03.01',
                'profile_id' => Profile::where('name', Profiles::PROFILE_IITO->value)->first()->id,
                'speciality_id' => Speciality::where('name', Specialities::SPECIALITY_IITVO->value)->first()->id,
                'study_form_id' => StudyForm::where('name', StudyForms::FORM_UNDERGRADUATE->value)->first()->id,


                'study_variants' => [
                    $this->studyVariantRepository->getByData(4, null, $fullTime)
                ],
                'payment_forms' => [
                    $budget,
                    $contract
                ]
            ],
            [
                'code' => '6.44.04.01',
                'profile_id' => Profile::where('name', Profiles::PROFILE_IITO->value)->first()->id,
                'speciality_id' => Speciality::where('name', Specialities::SPECIALITY_IITO->value)->first()->id,
                'study_form_id' => StudyForm::where('name', StudyForms::FORM_MAGISTRACY->value)->first()->id,


                'study_variants' => [
                    $this->studyVariantRepository->getByData(2, null, $fullTime),
                    $this->studyVariantRepository->getByData(2, 4, $distance)
                ],
                'payment_forms' => [
                    $contract
                ]
            ],
            [
                'code' => '2.09.03.04',
                'profile_id' => Profile::where('name', Profiles::PROFILE_PI->value)->first()->id,
                'speciality_id' => Speciality::where('name', Specialities::SPECIALITY_PI->value)->first()->id,
                'study_form_id' => StudyForm::where('name', StudyForms::FORM_UNDERGRADUATE->value)->first()->id,


                'study_variants' => [
                    $this->studyVariantRepository->getByData(4, null, $fullTime),
                    $this->studyVariantRepository->getByData(4, 8, $distance)
                ],
                'payment_forms' => [
                    $budget,
                    $contract
                ]
            ],
            [
                'code' => '2.09.04.04',
                'profile_id' => Profile::where('name', Profiles::PROFILE_PI->value)->first()->id,
                'speciality_id' => Speciality::where('name', Specialities::SPECIALITY_PI->value)->first()->id,
                'study_form_id' => StudyForm::where('name', StudyForms::FORM_MAGISTRACY->value)->first()->id,


                'study_variants' => [
                    $this->studyVariantRepository->getByData(2, 6, $distance)
                ],
                'payment_forms' => [
                    $contract,
                ]
            ]
        ];

        foreach($directions as $direction) {
            $direction = Direction::create([
                'code' => $direction['code'],
                'profile_id' => $direction['profile_id'],
                'speciality_id' => $direction['speciality_id'],
                'study_form_id' => $direction['study_form_id']
            ]);
            if(isset($directions['study_variants'])) {
                foreach($directions['study_variants'] as $studyVariant) {
                    $direction->studyVariants()->attach($studyVariant);
                }
            }
            if(isset($directions['payment_forms'])) {
                foreach($directions['payment_forms'] as $paymentForm) {
                    $direction->paymentForms()->attach($paymentForm);
                }
            }
        }
    }
}
