<?php

namespace App\Services\Admin;

use App\Models\RayEmployee;

class StoreRaysEmployeeService
{
    public function store(array $raysEmployeeData)
    {
        return RayEmployee::create($raysEmployeeData);
    }
}
