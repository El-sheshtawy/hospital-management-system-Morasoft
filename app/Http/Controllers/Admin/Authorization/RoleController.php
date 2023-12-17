<?php

namespace App\Http\Controllers\Admin\Authorization;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{

    public function index()
    {
        $roles = Role::select('id', 'name', 'created_at')->get();
        return view('dashboard.admin.authorization.roles.index',
            compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::select('id', 'name')->get();
        return view('dashboard.admin.authorization.roles.create', compact('permissions'));
    }

    public function store(StoreRoleRequest $request)
    {
        try {
            DB::beginTransaction();
           $role = Role::create([
                'name' => $request->name,
            ]);
           $role->givePermissionTo($request->permissions_assigned);
            DB::commit();
            session()->flash('add');
            return to_route('admin.roles.index');
        } catch (\Exception $exception) {
            DB::rollBack();
            return back()->withErrors([
                'error' => $exception->getMessage(),
            ]);
        }
    }

    public function edit(Role $role)
    {
        $permissions = Permission::select('id', 'name')->get();
        return view('dashboard.admin.authorization.roles.edit', compact('role', 'permissions'));
    }

    public function update(UpdateRoleRequest $request, Role $role)
    {
        try {
            DB::beginTransaction();
            $role->update([
                'name' => $request->name,
            ]);
            $role->syncPermissions($request->permissions_assigned);
            DB::commit();
            session()->flash('edit');
            return redirect()->route('admin.roles.index');
        } catch (\Exception $exception) {
            DB::rollBack();
            return back()->withErrors([
                'error' => $exception->getMessage(),
            ]);
        }
    }

    public function destroy(Role $role)
    {
        $role->delete();
        session()->flash('delete');
        return redirect()->route('admin.roles.index');
    }
}
