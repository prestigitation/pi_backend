<?php

namespace App\Http\Requests\Subjects;

use Illuminate\Foundation\Http\FormRequest;

class StoreSubjectRequest extends FormRequest
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
            'name' => 'required|string|max:30',
            'foreign_teachers' => 'nullable|array',
            'foreign_teachers.*.id' => 'integer|exists:App\Models\ForeignTeacher,id',
            'teachers' => 'nullable|array',
            'teachers.*.id' => 'integer|exists:App\Models\Teacher,id'
        ];
    }
}
