<?php

namespace App\Http\Requests;

use App\Rules\ForbiddenWords;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public static function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:2','max:255', new ForbiddenWords()],
            'email' => 'required|unique:users,email|ends_with:@gmail.com,@yahoo.com,@hotmail.com',
            'password' => 'required|confirmed|min:8|max:15',
            'password_confirmation' => 'required|min:8|max:15',
            'first_number' => 'required|numeric|digits:11|unique:users,phone_numbers->first_number',
            'second_number' => 'nullable|numeric|digits:11|unique:users,phone_numbers->first_number|different:first_number',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Input',
            'email' => 'Email address',
            'first_number' => 'First number',
            'second_number' => 'Second number',
        ];
    }

}
