<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRayRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'invoice_id' => 'integer|exists:invoices,id',
            'patient_id' => 'integer|exists:patients,id',
            'doctor_id' => 'integer|exists:doctors,id',
            'doctor_description' => 'required|string|min:2',
        ];
    }
}
