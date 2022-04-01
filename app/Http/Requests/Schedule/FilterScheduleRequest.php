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
            'audience' => 'nullable|array|min:1',
            'pair_number' => 'nullable|array|min:1',
            'type' => 'nullable|array|min:1',
            'teacher' => 'nullable|array|min:1',
            'foreign_teacher' => 'nullable|array|min:1',
            'subject' => 'nullable|array|min:1',
            'deleted' => 'nullable|boolean',
            'study_process' => 'nullable|array|min:1'
        ];
    }
}
