<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\FundAccount;
use App\Models\Patient;
use App\Models\PatientAccount;
use App\Models\PaymentAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentAccountController extends Controller
{
    public function index()
    {
        $payments = PaymentAccount::all();
        return view('dashboard.payments.index', compact('payments'));
    }


    public function create()
    {
        $patients = Patient::all();
        return view('dashboard.payments.create', compact('patients'));
    }


    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $payment = PaymentAccount::create([
                'date' => date('Y-m-d'),
                'patient_id' => $request->post('patient_id'),
                'amount' => $request->post('amount'),   // Money that patient will pay (مدين)
                'description' => $request->post('description'),
            ]);
            FundAccount::create([
                'date' => date('Y-m-d'),
                'single_invoice_id' => null,
                'payment_id' => $payment->id,
                'credit' => $request->post('amount'),  // Money that patient will pay (مدين)
                'debit' => 0.00,
            ]);
            PatientAccount::create([
                'date' => date('Y-m-d'),
                'patient_id' =>$request->post('patient_id'),
                'single_invoice_id' => null,
                'payment_id' => $payment->id,
                'credit' => 0.00,
                'debit' => $request->post('amount'), // Patient here is (دائن) because he pay money
            ]);
            DB::commit();
            session()->flash('add');
            return redirect()->route('admin.payments.index');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors([
                'error' => $e->getMessage(),
            ]);
        }
    }



    public function edit(string $id)
    {
        $payment = PaymentAccount::findOrFail($id);
        $patients = Patient::all();
        return view('dashboard.payments.edit', compact('patients', 'payment'));
    }


    public function update(Request $request)
    {
        try {
            DB::beginTransaction();

            $payment = PaymentAccount::findOrFail($request->post('payment_id'));
            $payment->update([
                'date' => date('Y-m-d'),
                'patient_id' => $request->post('patient_id'),
                'amount' => $request->post('amount'),
                'description' => $request->post('description'),
            ]);
            FundAccount::where('payment_id', $payment->id)->first()->update([
                'date' => date('Y-m-d'),
                'single_invoice_id' => null,
                'payment_id' => $payment->id,
                'credit' => $request->post('amount'),
                'debit' => 0.00,
            ]);
            PatientAccount::where('payment_id', $payment->id)->first()->update([
                'date' => date('Y-m-d'),
                'patient_id' =>$request->post('patient_id'),
                'single_invoice_id' => null,
                'payment_id' => $payment->id,
                'credit' => 0.00,
                'debit' => $request->post('amount'),
            ]);
            DB::commit();
            session()->flash('add');
            return redirect()->route('admin.payments.index');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors([
                'error' => $e->getMessage(),
            ]);
        }
    }


    public function destroy(Request $request)
    {
        try {
            $payment = PaymentAccount::findOrFail($request->post('payment_id'));
            FundAccount::where('payment_id', $payment->id)->delete();
            PatientAccount::where('payment_id', $payment->id)->delete();
            $payment->delete();
            DB::commit();
            session()->flash('delete');
            return redirect()->route('admin.payments.index');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors([
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function print(string $id)
    {
        $payment = PaymentAccount::findOrFail($id);
        return view('dashboard.payments.print', compact('payment'));
    }
}
