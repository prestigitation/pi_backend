<?php

namespace App\Http\Requests\Teachers;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTeacherRequest extends FormRequest
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
            'name' => 'required|string|max:255|min:2',
            'surname' => 'required|string|max:255|min:2',
            'patronymic' => 'required|string|max:255|min:2',
            'email' => 'required|string|email',
            'password' => 'nullable|string|min:6|max:255',
            'education_level_id' => 'required|exists:App\Models\EducationLevel,id',
            'study_link' => 'nullable|string|max:255',
            'education' => 'nullable|string|max:255',
            'proof_document_link' => 'nullable|string|max:255',
            'dissertation_proof' => 'nullable|string|max:255',
            'professional_interests' => 'nullable|string|max:255',
            'publications_count' => 'nullable',
            'projects_count' => 'nullable',
            'conferences_count' => 'nullable',
            'diploma_projects_count' => 'nullable',
        ];
    }
}
