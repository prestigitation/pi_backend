<?php

namespace App\Http\Requests\Schedule;

use Illuminate\Foundation\Http\FormRequest;

class FilterScheduleRequest extends FormRequest
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
            'groups' => 'nullable|array|min:1',
            'days' => 'nullable|array|min:1',
            'pair_numbers' => 'nullable|array|min:1',
            'pair_teachers' => 'nullable|array|min:1',
            'pair_audiences' => 'nullable|array|min:1',
            'pair_types' => 'nullable|array|min:1',
            'pair_subjects' => 'nullable|array|min:1',
            'deleted' => 'nullable|boolean'
        ];
    }
}
