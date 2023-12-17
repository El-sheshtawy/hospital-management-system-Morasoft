<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRaysEmployeeRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|min:2|max:255',
            'email' => ['required', 'email:rfc,dns',
                Rule::unique('ray_employees', 'email')->ignore($this->rays_employee->id)],
            'password' => 'nullable|min:8|max:20|confirmed',
            'password_confirmation' => 'nullable|required_with:password|min:8|max:20',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Rays employee name',
            'email' => 'Rays employee email address',
            'password' => 'Password',
        ];
    }

    public function messages()
    {
        return [
            'password_confirmation.required_unless' => 'You should confirm Password before update it',
        ];
    }
}
