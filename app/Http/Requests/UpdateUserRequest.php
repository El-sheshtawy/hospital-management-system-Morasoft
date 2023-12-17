<?php

namespace App\Http\Requests;

use App\Rules\ForbiddenWords;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public static function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:2','max:255', new ForbiddenWords()],
            'password' => 'required|confirmed|min:8|max:15',
            'password_confirmation' => 'required|min:8|max:15',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Input',
            'email' => 'Email address',
            'first_number' => 'First number',
            'second_number' => 'Second number',
            'password_confirmation' => 'Password Confirmation',
        ];
    }
}
