<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRaysEmployeeRequest;
use App\Http\Requests\UpdateRaysEmployeeRequest;
use App\Models\RayEmployee;
use App\Services\Admin\StoreRaysEmployeeService;
use App\Services\Admin\UpdateRaysEmployeeService;
use Illuminate\Support\Facades\Hash;


class AdminRaysEmployeeController extends Controller
{

    public function index()
    {
        $rays_employees = RayEmployee::select(['id', 'name', 'email', 'created_at'])->get();
        return view('dashboard/admin.rays-employees.index', compact('rays_employees'));
    }

    public function store(StoreRaysEmployeeRequest $request, StoreRaysEmployeeService $raysEmployeeService)
    {
        try {
          $raysEmployee = $raysEmployeeService->store(array_merge($request->validated(), [
              'password' => Hash::make('password'),
          ]));
          $raysEmployee->assignRole('rays_employee');
            session()->flash('add');
            return back();
        } catch (\Exception $exception) {
            return back()->withErrors([
                'error' => $exception->getMessage(),
            ]);
        }
    }

    public function update(UpdateRaysEmployeeRequest $request, RayEmployee $rays_employee,
                           UpdateRaysEmployeeService $updateRaysEmployeeService)
    {
        try {
            $updateRaysEmployeeService->update($request, $rays_employee);
            session()->flash('edit');
            return back();
        } catch (\Exception $exception) {
            return back()->withErrors([
                'error' => $exception->getMessage(),
            ]);
        }
    }

    public function destroy(RayEmployee $rays_employee)
    {
        $rays_employee->delete();
        session()->flash('delete');
        return redirect()->route('admin.rays-employees.index');
    }
}
