<?php

namespace App\Http\Requests\Schedule;

use Illuminate\Foundation\Http\FormRequest;

class UpdateScheduleRequest extends FormRequest
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
            'group_id' => 'exists:App\Models\Group,id',
            'day_id' => 'exists:App\Models\Day,id',
            'pair_number_id' => 'exists:App\Models\PairNumber,id',
            'pairs' => 'required|array',
            'pairs.*.id' => 'integer|exists:App\Models\Pair,id'
        ];
    }
}
