<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePatientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $static_update_patient_request_rules = [
            'birth_date' => 'required|date',
            'address' => 'nullable|string|min:2|max:255',
            'gender' => 'required|in:1,2',
            'blood_type' => 'required|in:1,2,3,4,5,6,7,8',
        ];

        $dynamic_update_patient_request_rules = [
            'email' => ['required', 'email:rfc,dns', 'ends_with:@gmail.com,@yahoo.com,@hotmail.com', 'max:255',
                Rule::unique('users', 'email')->ignore($this->patient->user->id)],

            'first_number' => ['required','numeric','digits:11',
                Rule::unique('users', 'phone_numbers->first_number')->ignore($this->patient->user->id)  ],

            'second_number' => ['nullable','numeric','digits:11', 'different:first_number',
                Rule::unique('users', 'phone_numbers->first_number')->ignore($this->patient->user->id)  ],
        ];
        return array_merge(UpdateUserRequest::rules(), $static_update_patient_request_rules,
            $dynamic_update_patient_request_rules );
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
        return[
            'email.unique' => 'There is a patient already joined with this email',
            'email.ends_with' => 'Join with one of this emails type: Gmail - Yahoo - Hotmail',
            'email.email' => 'This email is not exists in world',
            'first_number.unique' => 'There is a patient already joined with this number'
        ];
    }
}
