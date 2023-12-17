<?php

namespace App\Http\Controllers\Doctor\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Diagnosis;
use App\Models\Invoice;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DiagnosticsController extends Controller
{

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
           $diagnosis =  Diagnosis::create([
                'date' => date('Y-m-d'),
                'diagnosis' => $request->post('diagnosis'),
                'medicine' => $request->post('medicine'),
                'invoice_id' => $request->post('invoice_id') ,
                'patient_id' => $request->post('patient_id'),
                'doctor_id' => auth()->guard('doctor')->id(),
               'review_date' => $request->review_date ?
                   Carbon::parse($request->review_date)->format('Y-m-d H:i:s') : null,
               ]);
           $relatedInvoice = Invoice::where('id', $diagnosis->invoice_id)
               ->where('patient_id', $diagnosis->patient_id)
               ->where('doctor_id', $diagnosis->doctor->id)
               ->first();

         if ($relatedInvoice->invoice_status === 'pending' && !$diagnosis->review_date) {
             $relatedInvoice->update([
                 'invoice_status' => 'finish',
             ]);
         } elseif($relatedInvoice->invoice_status === 'pending' && $diagnosis->review_date) {
             $relatedInvoice->update([
                 'invoice_status' => 'revision',
             ]);
         } else {
             DB::rollBack();
             return redirect()->back()->withErrors([
                 'error' => 'Not allowed!',
             ]);
         }
         DB::commit();
            session()->flash('add');
            return redirect()->back();
        } catch (\Exception $exception) {
            DB::rollBack();
            return back()->withErrors([
                'error' => $exception->getMessage(),
            ]);
        }
    }

    public function showHistory(Patient $patient)
    {
        $previous_patient_diagnostics = Diagnosis::where('patient_id', $patient->id)->get();
        return view('dashboard.doctor.dashboard.diagnosis.show',
            compact('previous_patient_diagnostics', 'patient'));
    }


    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
