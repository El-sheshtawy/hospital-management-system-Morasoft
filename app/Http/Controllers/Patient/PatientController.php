<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePatientRequest;
use App\Http\Requests\UpdatePatientRequest;
use App\Interfaces\Patient\PatientRepositoryInterface;
use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    private PatientRepositoryInterface $patientRepository;

    public function __construct(PatientRepositoryInterface $patientRepository)
    {
        $this->patientRepository = $patientRepository;
    }

    public function index()
    {
        return $this->patientRepository->index();
    }


    public function create()
    {
        return $this->patientRepository->create();
    }


    public function store(StorePatientRequest $request)
    {
        return $this->patientRepository->store($request);
    }


    public function edit(Patient $patient)
    {
        return $this->patientRepository->edit($patient);
    }


    public function update(UpdatePatientRequest $request, Patient $patient)
    {
        return $this->patientRepository->update($request, $patient);
    }


    public function destroy(Request $request)
    {
        return $this->patientRepository->destroy($request);
    }

    public function show(Patient $patient)
    {
        return $this->patientRepository->show($patient);
    }
}
