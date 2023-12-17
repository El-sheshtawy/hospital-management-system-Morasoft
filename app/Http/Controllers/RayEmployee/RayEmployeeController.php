<?php

namespace App\Http\Controllers\RayEmployee;

use App\Http\Controllers\Controller;
use App\Models\Ray;
use App\Traits\UploadImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RayEmployeeController extends Controller
{
    use UploadImageTrait;

    private $collection;

    public function count($collection)
    {
        $this->collection = $collection;
        return count($this->collection);
    }

    public function showDashboard()
    {
        $employee = auth()->guard('ray_employee')->user();
        $rays_count = Ray::all()->count();
        $pending_rays_count = $this->count(Ray::where('status', 'pending')->get());
        $finished_rays_count = $this->count(Ray::where('status', 'finish')->get());
        $last_five_rays = Ray::with('patient.translations', 'doctor.translations')->latest()->take(5)->get();
        return view('dashboard.rays-employee.index',
            compact('employee', 'pending_rays_count', 'finished_rays_count',
                'last_five_rays', 'rays_count'));
    }

    public function showFinishedRays()
    {
        $rays = Ray::with(['patient', 'doctor', 'rayEmployee'])
            ->where('rays_employee_id', auth()->id())
            ->where('status', 'finish')
            ->get();
        return view('dashboard.rays-employee.rays.index', compact('rays'));
    }

    public function showPendingRays()
    {
        $rays = Ray::with(['patient', 'doctor', 'rayEmployee'])
            ->where('rays_employee_id', auth()->id())
            ->where('status', 'pending')
            ->get();
        return view('dashboard.rays-employee.rays.index', compact('rays'));
    }

    public function show(Ray $ray)
    {
        return view('dashboard.rays-employee.rays.create', compact('ray'));
    }

    public function update(Request $request, Ray $ray)
    {
        $request->validate([
            'ray_employee_id' => 'exists:ray_employees,id',
            'employee_description' => 'required|min:2',
            ]);
        try {
            DB::beginTransaction();
            $ray->update([
                'ray_employee_id' => auth()->guard('ray_employee')->id(),
                'ray_employee_description' => $request->employee_description,
                'status' => 'finish',
            ]);
            $this->uploadMultipleImages($request, $ray->id,
                'App\Models\Ray',public_path().'/images/rays');
            DB::commit();
            session()->flash('add');
            return redirect()->route('ray-employee.rays.index');
        } catch (\Exception $error) {
            DB::rollBack();
            return back()->withErrors([
                'error' => $error->getMessage(),
            ]);
        }
    }

    public function showAttachments(Ray $ray)
    {
        if ($ray->ray_employee_id !== auth()->guard('ray_employee')->id()) {
            abort(403);
        }
        return view('dashboard.rays-employee.rays.show-attachments', compact('ray'));
    }
}
