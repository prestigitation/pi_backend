<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class SearchUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => 'string|required_without_all:name,surname,patronymic',
            'name' => 'string|required_without_all:id,surname,patronymic',
            'surname' => 'string|required_without_all:name,id,patronymic',
            'patronymic' => 'string|required_without_all:name,surname,id'
        ];
    }
}
