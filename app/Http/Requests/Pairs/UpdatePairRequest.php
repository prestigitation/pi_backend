<?php

namespace App\Http\Requests\Pairs;

use App\Helpers\Enums\PairDateTypes;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePairRequest extends FormRequest
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
        $typeRules = PairDateTypes::getValues(PairDateTypes::cases());
        $typeString = implode(',', $typeRules); // получение правил для валидации типа проводимой пары : 'even,odd'
        return [
            'subject_id' => 'required|integer|exists:App\Models\Subject,id',
            'teacher_id' => 'required|integer|exists:App\Models\Teacher,user_id',
            'audience' => 'required|string|max:30',
            'type' => "in:$typeString|nullable",
            'additional_info' => 'string'
        ];
    }
}
