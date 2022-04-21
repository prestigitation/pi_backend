<?php

namespace App\Http\Requests\Regularity;

use Illuminate\Foundation\Http\FormRequest;

class StoreRegularityRequest extends FormRequest
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
            'audience_id' => 'required|integer|exists:App\Models\Audience,id',
            'subject_id' => 'required|integer|exists:App\Models\Subject,id',
            'type_id' => 'nullable|integer|exists:App\Models\Type,id',
            'pair_format_id' => 'nullable|integer|exists:App\Models\PairFormat,id',
            'study_process_id' => 'nullable|integer|exists:App\Models\StudyProcess,id',
            'additional_info' => 'nullable|string|max:255',
            'start_date_info' => 'nullable|string|max:255',
        ];
    }
}
