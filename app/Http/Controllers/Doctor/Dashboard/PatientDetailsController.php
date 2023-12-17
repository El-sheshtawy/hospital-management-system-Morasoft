<?php

namespace App\Http\Controllers\Doctor\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Patient;
use App\Services\Doctor\PatientDetailsService;
use Illuminate\Http\Request;

class PatientDetailsController extends Controller
{
    public function show(Invoice $invoice, PatientDetailsService $patientDetailsService)
    {
       return $patientDetailsService->show($invoice);
    }
}
