<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePatientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {

       $patientRequestRules = [
            'birth_date' => 'required|date',
            'address' => 'nullable|string|min:2|max:255',
            'gender' => 'required|in:1,2',
            'blood_type' => 'required|in:1,2,3,4,5,6,7,8',
        ];
       return array_merge(StoreUserRequest::rules(), $patientRequestRules);
    }

    public function attributes()
    {
        return [
            'name' => 'Patient name',
            'email' => 'Email address',
            'birth_date' => 'Birth date',
            'address' => 'Patient Address',
            'gender' => 'Gender',
            'blood_type' => 'Blood type',
            'first_number' => 'First phone number',
            'second_number' => 'Second phone number',
        ];
    }

    public function messages()
    {
        return [
            'email.unique' => 'An Patient already joined with this email',
            'email.ends_with' => 'Join with one of this emails type: Gmail - Yahoo - Hotmail',
            'email.email' => 'This email is not exists in world',
            'first_number.unique' => 'An Patient already joined with this number'
        ];
    }
}

//Save all
