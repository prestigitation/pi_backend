<?php

namespace App\Http\Requests\Schedule;

use Illuminate\Foundation\Http\FormRequest;

class StoreScheduleRequest extends FormRequest
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
            'group_id' => 'required|integer|exists:App\Models\Group,id',
            'day_id' => 'required|integer|exists:App\Models\Day,id',
            'pair_number_id' => 'required|integer|exists:App\Models\PairNumber,id',
            'pairs' => 'required|array|min:1|max:2',
            'pairs.*.additional_info' => 'string|nullable',
            'pairs.*.audience_id' => 'integer|exists:App\Models\Audience,id',
            'pairs.*.subject_id' => 'integer|exists:App\Models\Subject,id',
            'pairs.*.teacher_id' => 'integer|exists:App\Models\Teacher,id',
            'pairs.*.type_id' => 'integer|exists:App\Models\Type,id|distinct',
        ];
    }
}
