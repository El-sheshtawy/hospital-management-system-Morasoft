<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDoctorPassworRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6'
        ];
    }

    public function messages()
    {
        return [
            'password.required' => 'You must enter a valid password',
            'password.min' => 'password must be more than 5 chars',
            'password.confirmed' => "The password confirmation doesn't match new password",
            'password_confirmation.required' => 'You must enter a valid password',
            'password_confirmation.min' => 'password must be more than 5 chars',
        ];
    }
}
