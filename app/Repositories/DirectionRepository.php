<?php

namespace App\Repositories;

use App\Models\Direction;

class DirectionRepository {
    public function getAll()
    {
        return Direction::all();
    }

    public function create(array $data)
    {
        $direction = Direction::create([
            'code' => $data['code'],
            'profile_id' => $data['profile'],
            'speciality_id' => $data['speciality'],
            'study_form_id' => $data['study_form']
        ]);

        foreach($data['study_variants'] as $studyVariant) {
            $direction->studyVariants()->attach($studyVariant['id']);
        }
        foreach($data['payment_forms'] as $paymentForm) {
            $direction->paymentForms()->attach($paymentForm['id']);
        }
    }
}
