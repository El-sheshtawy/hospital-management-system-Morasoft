<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRayRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'description' => 'required|string|min:2',
            'invoice_id' => 'integer|exists:invoices,id',
            'patient_id' => 'integer|exists:patients,id',
            'doctor_id' => 'integer|exists:doctors,id',
        ];
    }
}
