<?php

namespace App\Http\Controllers\Doctor\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRayRequest;
use App\Http\Requests\UpdateRayRequest;
use App\Models\Ray;
use App\Services\Doctor\RayService;

class RayController extends Controller
{
    public function store(StoreRayRequest $request, RayService $rayService)
    {
        try {
            $rayService->store($request);
            session()->flash('add');
            return back();
        } catch (\Exception $exception) {
            return redirect()->back()->withErrors([
                'error' => $exception->getMessage(),
            ]);
        }
    }

    public function update(UpdateRayRequest $request, Ray $ray, RayService $rayService)
    {
        try {
            $rayService->update($request, $ray);
            session()->flash('edit');
            return back();
        } catch (\Exception $exception) {
            return redirect()->back()->withErrors([
                'error' => $exception->getMessage(),
            ]);
        }
    }

    public function destroy(Ray $ray, RayService $rayService)
    {
         $rayService->destroy($ray);
         session()->flash('delete');
         return back();
    }
}
