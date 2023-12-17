<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRaysEmployeeRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|min:2|max:255',
            'email' => 'required|email:rfc,dns|ends_with:@gmail.com|unique:ray_employees,email',
            'password' => 'required|confirmed|min:8|max:15',
            'password_confirmation' => 'required|min:8|max:15',
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
}
