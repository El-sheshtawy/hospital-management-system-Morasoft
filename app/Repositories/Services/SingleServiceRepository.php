<?php

namespace App\Repositories\Services;

use App\Interfaces\Services\SingleServiceRepositoryInterface;
use App\Models\SingleService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreSingleServiceRequest;

class SingleServiceRepository implements SingleServiceRepositoryInterface
{

    public function index()
    {
        $singleServices = SingleService::all();
        return view('dashboard.services.single-service.index', compact('singleServices'));
    }

    public function store(StoreSingleServiceRequest $request)
    {
        try {
            DB::beginTransaction();
            SingleService::create([
                'name' => $request->post('name'),
                'description'=> $request->post('description'),
                'price' => $request->post('price'),
                'updated_at' => null,
            ]);
            DB::commit();
            session()->flash('add');
            return redirect()->route('admin.single-service.index');
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->withErrors([
                'error' => $exception->getMessage(),
            ]);
        }
    }

    public function update(Request $request)
    {
        try {
            DB::beginTransaction();
            $singleService = SingleService::findOrFail($request->post('service_id'));
            $singleService->update([
                'name' => $request->post('name'),
                'price' => $request->post('price'),
                'description'=> $request->post('description'),
                'active' => $request->post('status'),
                'updated_at' => Carbon::now(),
            ]);
            DB::commit();
            session()->flash('add');
            return redirect()->route('admin.single-service.index');
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->withErrors([
                'error' => $exception->getMessage(),
            ]);
        }
    }

    public function destroy(Request $request)
    {
        SingleService::findOrFail($request->post('service_id'))->delete();
        session()->flash('delete');
        return redirect()->route('admin.single-service.index');
    }
}