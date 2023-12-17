<?php

namespace App\Services\Admin;

use App\Models\RayEmployee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UpdateRaysEmployeeService
{
    public function update(Request $request, RayEmployee $rayEmployee)
    {
        $rayEmployee->update([
            'name' => $request->name,
            'email' => $request->email ,
            'password' => $request->password ? Hash::make($request->password) : $rayEmployee->password,
            ]);
    }
}
