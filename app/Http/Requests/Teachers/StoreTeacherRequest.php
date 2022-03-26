<?php

namespace App\Http\Requests\Teachers;

use Illuminate\Foundation\Http\FormRequest;

class StoreTeacherRequest extends FormRequest
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
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|max:255',
            'study_link' => 'nullable|string|max:255',
            'education_level_id' => 'required|exists:App\Models\EducationLevel,id',
            'education' => 'nullable|string|max:255',
            'proof_document_link' => 'nullable|string|max:255',
            'dissertation_proof' => 'nullable|string|max:255',
            'professional_interests' => 'nullable|string|max:255',
            'publications_count' => 'nullable|integer',
            'projects_count' => 'nullable|integer',
            'conferences_count' => 'nullable|integer',
            'diploma_projects_count' => 'nullable|integer',
        ];
    }
}
