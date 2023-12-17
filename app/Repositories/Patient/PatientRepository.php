<?php

namespace App\Repositories\Patient;

use App\Http\Requests\StorePatientRequest;
use App\Http\Requests\UpdatePatientRequest;
use App\Interfaces\Patient\PatientRepositoryInterface;
use App\Models\Patient;
use App\Models\PatientAccount;
use App\Models\ReceiptAccount;
use App\Models\Invoice;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PatientRepository implements PatientRepositoryInterface
{
    public static array $bloodTypes = array(
       1 => '+O',
       2 => '-O',
       3 => '+A' ,
       4 => '-A' ,
       5 => '+B' ,
       6 => '-B' ,
       7 => '+AB',
       8 => '-AB',
    );

    public static array $genders = array(
       1 => 'male',
       2 => 'female',
       3 => 'another'
    );

    public function index()
    {
        $patients = Patient::with('user.translations')->get();
        return view('dashboard.patient.index', compact('patients'));
    }

    public function create()
    {
        return view('dashboard.patient.create', [
            'genders'  => self::$genders,
            'bloodTypes' => self::$bloodTypes,
        ]);
    }

    public function store(StorePatientRequest $request)
    {
        try {
            DB::beginTransaction();

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone_numbers' =>[ 'first_number' => $request->first_number, 'second_number' => $request->second_number],
            ]);

            Patient::create([
                'user_id' => $user->id,
                'address' => $request->post('address'),
                'birth_date' => $request->post('birth_date'),
                'gender' => $request->post('gender'),
                'blood_type' => $request->post('blood_type'),
            ]);

           DB::commit();
            session()->flash('add');
            return redirect()->route('admin.patients.index');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors([
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function edit(Patient $patient)
    {
        return view('dashboard.patient.edit', [
            'genders'  => self::$genders,
            'bloodTypes' => self::$bloodTypes,
            'patient' => $patient,
        ]);
    }

    public function update(UpdatePatientRequest $request, Patient $patient)
    {
        try {
            DB::beginTransaction();
            $patient ->update([
                'address' => $request->post('address'),
                'birth_date' => $request->post('birth_date'),
                'gender' => $request->post('gender'),
                'blood_type' => $request->post('blood_type'),
            ]);
            $patient->user->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone_numbers' =>[ 'first_number' => $request->first_number, 'second_number' => $request->second_number],
            ]);
            DB::commit();
            session()->flash('edit');
            return redirect()->route('admin.patients.index');
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
            $id = $request->post('patient_id');
           $patient = Patient::findOrFail($id);
           $patient->delete();
           DB::commit();
            session()->flash('delete');
            return redirect()->route('admin.patients.index');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors([
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function show(Patient $patient)
    {
        $patientInvoices = Invoice::with(['singleService', 'groupServices'])->where('patient_id', $patient->id)->get();
        $patientReceipts = ReceiptAccount::where('patient_id', $patient->id)->get();
        $patientAccounts = PatientAccount::with(['singleInvoice', 'receiptAccount', 'paymentAccount'])
            ->where('patient_id', $patient->id)->get();
        return view('dashboard.patient.show', [
            'patient' => $patient,
            'patientInvoices' => $patientInvoices,
            'patientReceipts' => $patientReceipts,
            'patientAccounts' => $patientAccounts,
        ]);
    }
}
