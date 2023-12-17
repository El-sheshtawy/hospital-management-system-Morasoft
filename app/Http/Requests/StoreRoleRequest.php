<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;

class StoreRoleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'name' => 'required|string|min:2|max:255|unique:roles,name',
            'permissions_assigned' => 'required|array|min:1',
            'permissions_assigned.*' => 'required|integer|exists:permissions,id',
        ];
    }
}
