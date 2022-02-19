<?php

namespace App\Repositories;

use App\Http\Requests\Directions\UpdateDirectionRequest;
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

        $this->attachEntities($data, $direction);
    }

    public function attachEntities(array $data, Direction $direction)
    {
        foreach($data['study_variants'] as $studyVariant) {
            $direction->studyVariants()->attach($studyVariant['id']);
        }
        foreach($data['payment_forms'] as $paymentForm) {
            $direction->paymentForms()->attach($paymentForm['id']);
        }
    }

    public function detachEntities(Direction $direction)
    {
        $direction->paymentForms()->detach();
        $direction->studyVariants()->detach();
    }

    public function update(UpdateDirectionRequest $request, int $id)
    {
        $direction = Direction::findOrFail($id);
        $data = $request->all();
        $direction->update($data);

        $this->detachEntities($direction);

        $this->attachEntities($data, $direction);
    }

    public function delete(int $id)
    {
        $direction = Direction::findOrFail($id);
        $this->detachEntities($direction);
        $direction->delete();
    }
}
