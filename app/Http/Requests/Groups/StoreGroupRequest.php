<?php

namespace App\Http\Requests\Groups;

use Illuminate\Foundation\Http\FormRequest;

class StoreGroupRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'curator_id' => 'required|integer|exists:App\Models\Teacher,user_id|different:headman_id',
            'headman_id' => 'required|integer|exists:App\Models\User,id|different:curator_id',
            'direction_id' => 'required|integer|exists:App\Models\Direction,id',
            'study_variant_id' => 'required|integer|exists:App\Models\StudyVariant,id',
            'is_active' => 'required|boolean',
            'users' => 'nullable|array'
        ];
    }
}
