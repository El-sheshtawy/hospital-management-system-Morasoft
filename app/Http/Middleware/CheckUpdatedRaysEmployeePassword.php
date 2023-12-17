<?php

namespace App\Http\Middleware;

use App\Models\RayEmployee;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;

class CheckUpdatedRaysEmployeePassword
{
    public function handle(Request $request, Closure $next)
    {
        $authenticatedRaysEmployee = auth()->guard('ray_employee')->user();
        $raysEmployee = RayEmployee::find($authenticatedRaysEmployee->id);
        if ($authenticatedRaysEmployee->password !== $raysEmployee->password) {
            Auth::guard('ray_employee')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }
        return $next($request);
    }
}
