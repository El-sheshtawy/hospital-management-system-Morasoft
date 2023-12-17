<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\FundAccount;
use App\Models\Patient;
use App\Models\PatientAccount;
use App\Models\ReceiptAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReceiptAccountController extends Controller
{

    public function index()
    {
        $receipts = ReceiptAccount::all();
        return view('dashboard.receipts.index', compact('receipts'));
    }


    public function create()
    {
        $patients = Patient::all();
        return view('dashboard.receipts.create', compact('patients'));
    }


    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

           $receipt = ReceiptAccount::create([
                'date' => date('Y-m-d'),
                'patient_id' => $request->post('patient_id'),
                'amount' => $request->post('amount'),   // Money that patient will pay (مدين)
                'description' => $request->post('description'),
            ]);
            FundAccount::create([
                'date' => date('Y-m-d'),
                'single_invoice_id' => null,
                'receipt_id' => $receipt->id,
                'debit' => $request->post('amount'),  // Money that patient will pay (مدين)
                'credit' => 0.00,
            ]);
            PatientAccount::create([
                'date' => date('Y-m-d'),
                'patient_id' =>$request->post('patient_id'),
                'single_invoice_id' => null,
                'receipt_id' => $receipt->id,
                'debit' => 0.00,
                'credit' => $request->post('amount'), // Patient here is (دائن) because he pay money
            ]);
            DB::commit();
            session()->flash('add');
            return redirect()->route('admin.receipts.index');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors([
                'error' => $e->getMessage(),
            ]);
        }
    }


    public function edit(string $id)
    {
        $receipt = ReceiptAccount::findOrFail($id);
        $patients = Patient::all();
        return view('dashboard.receipts.edit', compact('receipt', 'patients'));
    }


    public function update(Request $request)
    {
        try {
            DB::beginTransaction();
            $receipt = ReceiptAccount::findOrFail($request->post('receipt_id'));
            $receipt->update([
                'date' => date('Y-m-d'),
                'patient_id' => $request->post('patient_id'),
                'amount' => $request->post('amount'),   // Money that patient will pay (مدين)
                'description' => $request->post('description'),            ]);
             FundAccount::where('receipt_id', $receipt->id)->first()->update([
                 'date' => date('Y-m-d'),
                 'single_invoice_id' => null,
                 'receipt_id' => $receipt->id,
                 'debit' => $request->post('amount'),  // Money that patient will pay (مدين)
                 'credit' => 0.00,
             ]);
            PatientAccount::where('receipt_id', $receipt->id)->first()->update([
                'date' => date('Y-m-d'),
                'patient_id' =>$request->post('patient_id'),
                'single_invoice_id' => null,
                'receipt_id' => $receipt->id,
                'debit' => 0.00,
                'credit' => $request->post('amount'), // Patient here is (دائن) because he pay money
            ]);
            DB::commit();
            session()->flash('edit');
            return redirect()->route('admin.receipts.index');
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
            DB::beginTransaction();
            $receipt = ReceiptAccount::findOrFail($request->post('receipt_id'));
            FundAccount::where('receipt_id', $receipt->id)->delete();
            PatientAccount::where('receipt_id', $receipt->id)->delete();
            $receipt->delete();
            DB::commit();
            session()->flash('delete');
            return redirect()->route('admin.receipts.index');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors([
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function print($id)
    {
        $receipt = ReceiptAccount::findOrFail($id);
        return view('dashboard.receipts.print', compact('receipt'));
    }
}
