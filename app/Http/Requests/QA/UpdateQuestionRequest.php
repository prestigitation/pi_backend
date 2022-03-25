<?php

namespace App\Http\Requests\QA;

use Illuminate\Foundation\Http\FormRequest;

class UpdateQuestionRequest extends FormRequest
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
            'nsp' => 'required|string|max:75',
            'email' => 'required|string|max:30',
            'question' => 'required|string|max:75',
            'answer' => 'string|nullable'
        ];
    }
}
