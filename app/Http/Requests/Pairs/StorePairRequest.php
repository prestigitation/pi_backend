<?php

namespace App\Http\Requests\Pairs;

use App\Helpers\Enums\PairDateTypes;
use Illuminate\Foundation\Http\FormRequest;

class StorePairRequest extends FormRequest
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
            'subject_id' => 'required|integer|exists:App\Models\Subject,id',
            'teacher_id' => 'required|integer|exists:App\Models\User,id',
            'audience' => 'required|string|max:30',
            'type_id' => "exists:App\Models\Type,id|nullable",
            'additional_info' => 'string'
        ];
    }
}
