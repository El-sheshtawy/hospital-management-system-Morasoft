<?php

namespace App\Services\Doctor;

use App\Models\Diagnosis;
use App\Models\Invoice;
use App\Models\Laboratory;
use App\Models\Patient;
use App\Models\Ray;

class PatientDetailsService
{
    public function show(Invoice $invoice)
    {
        $patient = Patient::where('id', $invoice->patient_id)->first();
        $diagnosis_reports = Diagnosis::where('patient_id', $patient->id)
            ->with(['doctor:id,phone', 'doctor.translations'])
            ->get();
        $patient_rays = Ray::where('patient_id', $patient->id)
            ->with(['doctor:id,phone', 'doctor.translations', 'rayEmployee'])
            ->get();
        $patient_laboratories = Laboratory::where('patient_id', $patient->id)
            ->with(['doctor:id,phone', 'doctor.translations'])
            ->get();

        return view('dashboard.doctor.patient-details',
            compact('patient', 'diagnosis_reports', 'patient_rays', 'patient_laboratories'));
    }
}
