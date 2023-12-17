<?php

namespace App\Http\Controllers\Admin\Authorization;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Doctor;
use App\Models\RayEmployee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::select('id', 'name', 'created_at')->get();
        return view('dashboard.admin.authorization.permissions.index',
            compact('permissions'));
    }

    public function create()
    {
        $roles = Role::select('id', 'name')->get();
        return view('dashboard.admin.authorization.permissions.create', compact('roles'));
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
                 Permission::create([
                    'name' => $request->name,
                ]);
           DB::commit();
           session()->flash('add');
            return redirect()->route('admin.permissions.index');
        } catch (\Exception $exception) {
            DB::rollBack();
            return back()->withErrors([
                'error' => $exception->getMessage(),
            ]);
        }
    }


    public function edit(Permission $permission)
    {
        $roles = Role::select('id', 'name')->get();
        return view('dashboard.admin.authorization.permissions.edit',
            compact('permission', 'roles'));
    }


    public function update(Request $request, Permission $permission)
    {
        try {
            $permission->update([
                'name' => $request->name,
            ]);
            session()->flash('edit');
            return redirect()->route('admin.permissions.index');
        } catch (\Exception $exception) {
            return back()->withErrors([
                'error' => $exception->getMessage(),
            ]);
        }
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();
        session()->flash('delete');
        return redirect()->route('admin.permissions.index');
    }

    public function createPermissionForUsers()
    {
        $admins = Admin::with('user.translations')->get(['id', 'user_id']);
        $doctors = Doctor::with('user.translations')->get(['id', 'user_id']);
        $rays_employees = RayEmployee::with('user.translations')->get(['id', 'user_id']);
        return view('dashboard.admin.authorization.permissions.add-permission-for-user',
            compact('admins', 'doctors', 'rays_employees'));
    }

    public function storePermissionForUsers(Request $request)
    {
        try {
            DB::beginTransaction();

                 Permission::create([
                    'name' => $request->name,
                ]);


            foreach ($request->users as $userId) {
                $user = User::find($userId);
                if (!$user->hasDirectPermission($request->name)) {
                    $user->givePermissionTo($request->name);
                }
            }
            DB::commit();
            session()->flash('add');
            return redirect()->route('admin.permissions.index');
        } catch (\Exception $exception) {
            DB::rollBack();
            return back()->withErrors([
                'error' => $exception->getMessage(),
            ]);
        }
    }
}
