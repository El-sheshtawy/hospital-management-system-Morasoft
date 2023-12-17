<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInsuranceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => "required|unique:insurance_translations,name,{$this->id}",
            'insurance_code' => 'required',
            'discount_percentage' =>'required|numeric',
            'percentage_costs_insurance' =>'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => trans('validation.required'),
            'name.unique' => trans('validation.unique'),
            'insurance_code.required' => trans('validation.required'),
            'discount_percentage.required' => trans('validation.required'),
            'discount_percentage.numeric' => trans('validation.numeric'),
            'percentage_costs_insurance.required' => trans('validation.required'),
            'percentage_costs_insurance.numeric' => trans('validation.numeric'),
        ];
    }
}
