<?php

namespace App\Interfaces\Patient;

use App\Http\Requests\StorePatientRequest;
use App\Http\Requests\UpdatePatientRequest;
use App\Models\Patient;
use Illuminate\Http\Request;

interface PatientRepositoryInterface
{
    public function index();
    public function create();
    public function store(StorePatientRequest $request);
    public function edit(Patient $patient);
    public function update(UpdatePatientRequest $request, Patient $patient);
    public function destroy(Request $request);
    public function show(Patient $patient);
}
