<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDoctorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        $storeUserRequestRules = StoreUserRequest::rules();

        $storeDoctorRequestRules =  [
            'section_id' => 'required|integer|exists:sections,id',
            'appointments' => 'required|array|min:1|max:7',
            'appointments.*' => 'required|integer|exists:appointments,id',
            'password' => 'required|confirmed|min:8|max:15',
            'password_confirmation' => 'required|min:8|max:15',
        ];
        return array_merge($storeUserRequestRules, $storeDoctorRequestRules);
    }

    public function attributes()
    {
        return [
            'section_id' => 'Section',
            'appointments' =>'Appointments',
            'appointments.*' => 'Appointment',
            'password' => 'Password',
            'password_confirmation' => 'Password Confirmation' ,
        ];
    }
}
