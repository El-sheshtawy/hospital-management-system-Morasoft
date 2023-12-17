<?php

namespace App\Http\Controllers\Doctor\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLaboratoryRequest;
use App\Http\Requests\UpdateLaboratoryRequest;
use App\Models\Laboratory;
use App\Services\Doctor\LaboratoryService;

class laboratoryController extends Controller
{
    public function store(StoreLaboratoryRequest $request, LaboratoryService $laboratoryService)
    {
        try {
            $laboratoryService->store($request->validated());
            session()->flash('add');
            return back();
        } catch (\Exception $exception) {
            return redirect()->back()->withErrors([
                'error' => $exception->getMessage(),
            ]);
        }
    }

    public function update(UpdateLaboratoryRequest $request, Laboratory $laboratory, LaboratoryService $laboratoryService)
    {
        try {
            $laboratoryService->update($request->validated(), $laboratory);
            session()->flash('edit');
            return back();
        } catch (\Exception $exception) {
            return redirect()->back()->withErrors([
                'error' => $exception->getMessage(),
            ]);
        }
    }

    public function destroy(Laboratory $laboratory, LaboratoryService $laboratoryService)
    {
        $laboratoryService->destroy($laboratory);
        session()->flash('delete');
        return back();
    }
}
