<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRegisterRequest extends FormRequest
{

    public function rules(): array
    {

        return [
            'username' => ['required','string','min:5','max:30', Rule::unique('users', 'username')],
            'phone' => ['required', 'phone:mobile']
        ];
    }
}
