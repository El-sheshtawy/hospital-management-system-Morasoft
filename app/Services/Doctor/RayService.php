<?php

namespace App\Services\Doctor;

use App\Http\Requests\StoreRayRequest;
use App\Http\Requests\UpdateRayRequest;
use App\Models\Ray;

class RayService
{
    public function store(StoreRayRequest $request): Ray
    {
       return Ray::create([
           'invoice_id' => $request->invoice_id,
           'patient_id' => $request->patient_id,
           'doctor_id' => $request->doctor_id,
           'doctor_description' => $request->doctor_description,
        ]);
    }

    public function update(UpdateRayRequest $request, Ray $ray)
    {
        return $ray->update([
            'invoice_id' => $request->invoice_id,
            'patient_id' => $request->patient_id,
            'doctor_id' => $request->doctor_id,
            'doctor_description' => $request->doctor_description,
        ]);
    }

    public function destroy(Ray $ray)
    {
       return $ray->delete();
    }
}
