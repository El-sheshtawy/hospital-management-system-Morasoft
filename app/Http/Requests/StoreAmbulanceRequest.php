<?php

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAmbulanceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'car_number' => ['required', 'numeric', 'digits_between:5,10',"unique:ambulances,car_number,{$this->id}"],
            'car_model' => 'required|string|min:2',
            'car_year_made' => 'required|numeric|digits:4',
            'ownership_status' => ['required',Rule::in([0, 1])],
            'driver_id' => 'required|exists:App\Models\Driver,id',
            'notes' => 'nullable|string|min:2',
        ];
    }
}
