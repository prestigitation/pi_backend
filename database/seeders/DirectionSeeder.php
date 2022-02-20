<?php

namespace Database\Seeders;

use App\Helpers\Enums\EducationLevels;
use App\Helpers\Enums\PaymentForms;
use App\Helpers\Traits\EnumHelper;
use App\Helpers\Enums\Profiles;
use App\Helpers\Enums\Specialities;
use App\Helpers\Enums\StudyForms;
use App\Helpers\Enums\TimeForms;
use App\Models\Direction;
use App\Models\EducationLevel;
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
                ],
                'preparation_exams' => [1,2]
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
                ],
                'preparation_exams' => [1,2],
                'description' => '
                Обучение по данному направлению осуществляется на договорной основе.
                Для успешного овладения навыками профессии необходимо: хорошее знание математики, родного языка, информатики, умения и навыки по практическому использованию информационных технологий, умение находить различные решения практических задач с помощью ИКТ.
                Требования, предъявляемые профессией: целеустремленность, усидчивость, умение работать с учебной литературой, математические способности.
                Сфера применения полученных знаний по профилю: образование, социальная сфера, культура.
                '
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
                ],
                'preparation_exams' => [1,2]
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
                ],
                'preparation_exams' => [1,2]
            ]
        ];

        foreach($directions as $direction) {
            $dir = Direction::create([
                'code' => $direction['code'],
                'profile_id' => $direction['profile_id'],
                'speciality_id' => $direction['speciality_id'],
                'study_form_id' => $direction['study_form_id'],
            ]);
            if(isset($direction['study_variants'])) {
                foreach($direction['study_variants'] as $studyVariant) {
                    $dir->studyVariants()->attach($studyVariant);
                }
            }
            if(isset($direction['payment_forms'])) {
                foreach($direction['payment_forms'] as $paymentForm) {
                    $dir->paymentForms()->attach($paymentForm);
                }
            }
            if(isset($direction['preparation_exams'])) {
                foreach($direction['preparation_exams'] as $preparationExam) {
                    $dir->preparationExams()->attach($preparationExam);
                }
            }
        }
    }
}
