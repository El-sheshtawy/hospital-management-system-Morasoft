<?php

namespace App\Http\Controllers\Doctor\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDoctorRequest;
use App\Http\Requests\UpdateDoctorPassworRequest;
use App\Interfaces\Doctor\DoctorRepositoryInterface;
use App\Models\Doctor;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DoctorController extends Controller
{
    private DoctorRepositoryInterface $doctorRepository;

    public function __construct(DoctorRepositoryInterface $doctorRepository)
    {
        $this->doctorRepository = $doctorRepository;
    }

    public function index()
    {
        return $this->doctorRepository->index();
    }


    public function create()
    {
        return $this->doctorRepository->create();
    }


    public function store(StoreDoctorRequest $request)
    {
        return $this->doctorRepository->store($request);
    }

    public function edit(string $id)
    {
        return $this->doctorRepository->edit($id);
    }


    public function update(Request $request, string $id)
    {
        return $this->doctorRepository->update($request, $id);
    }


    public function destroy(Request $request)
    {
      return $this->doctorRepository->destroy($request);
    }

    public function updatePassword(UpdateDoctorPassworRequest $request)
    {
      return  $this->doctorRepository->updatePassword($request);
    }

    public function updateStatus(Request $request)
    {
        return $this->doctorRepository->updateStatus($request);
    }

    public function showDashboard()
    {
        $authDoctor = auth()->guard('doctor')->user();
        $doctorInvoices = Invoice::where('doctor_id', $authDoctor->getAuthIdentifier())->get();
        $doctorInvoicesCount = $doctorInvoices->count();
        $doctorPendingInvoicesCount = $doctorInvoices->where('invoice_status', 'pending')->count();
        $doctorFinishedInvoicesCount = $doctorInvoices->where('invoice_status', 'finish')->count();
        $doctorRevisionsInvoicesCount = $doctorInvoices->where('invoice_status', 'revision')->count();
        return view('dashboard.doctor.dashboard.index',
            compact('authDoctor', 'doctorInvoicesCount', 'doctorPendingInvoicesCount',
                'doctorFinishedInvoicesCount', 'doctorRevisionsInvoicesCount'));
    }

    public function show($id)
    {
        return Invoice::find($id);
    }

    public function showAllInvoices()
    {
            $invoices = Invoice::allDoctorInvoices()->get();
            $invoices_statuses = $invoices->pluck('invoice_status')->toArray();
            return view('dashboard.doctor.dashboard.invoices.index',
                compact('invoices', 'invoices_statuses'));
    }

    public function showCompletedInvoices()
    {
        $invoices = Invoice::doctorCompletedInvoices()->get();
        $invoices_statuses =  $invoices->pluck('invoice_status')->toArray();
        return view('dashboard.doctor.dashboard.invoices.index',
            compact('invoices', 'invoices_statuses'));
    }

    public function showRevisionsInvoices()
    {
        $invoices = Invoice::doctorRevisionsInvoices()->get();
        $invoices_statuses =  $invoices->pluck('invoice_status')->toArray();
        return view('dashboard.doctor.dashboard.invoices.index',
            compact('invoices', 'invoices_statuses'));
    }

//    public function rolesAndPermissionsInfo(Doctor $doctor)
//    {
//        if ($doctor->id !== auth()->guard('doctor')->id()) {
//            abort(403);
//        }
//      //  return $doctor->getPermissionsViaRoles()->pluck('name');
//        return Doctor::permission('edit_diagnosis')->count();
//    }
}
