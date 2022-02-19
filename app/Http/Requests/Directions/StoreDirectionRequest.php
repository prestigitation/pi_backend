<?php

namespace App\Http\Requests\Directions;

use Illuminate\Foundation\Http\FormRequest;

class StoreDirectionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'code' => 'required|string',
            'study_form' => 'required|numeric',
            'speciality' => 'required|numeric',
            'profile' => 'required|numeric',
            'study_variants' => 'required|array',
            'study_variants.*.id' => 'required|numeric',
            'payment_forms' => 'required|array',
            'payment_forms.*.id' => 'required|numeric'
        ];
    }
}
