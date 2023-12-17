<?php


namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRoleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:255',
                Rule::unique('roles', 'name')->ignore($this->role->id)],
            'guard_name' => ['required', Rule::in(array_keys(config('auth.guards'))), 'string'],
            'permissions_assigned' => 'required|array|min:1',
            'permissions_assigned.*' => 'required|integer|exists:permissions,id',
        ];
    }
}

//                 Rule::unique('roles', 'name')->ignore($this->role->id) ],
