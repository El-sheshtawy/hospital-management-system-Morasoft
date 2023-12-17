<?php

namespace App\Http\Controllers\Ambulances;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAmbulanceRequest;
use App\Models\Ambulance;
use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AmbulancesController extends Controller
{
    public function index()
    {
        $ambulances = Ambulance::with(['user.translations'])->withTranslation()->get();
        return view('dashboard.ambulances.index',compact('ambulances'));
    }

   public function create()
    {
        $drivers = Driver::with('user.translations')->get(['id', 'user_id']);
        return view('dashboard.ambulances.create', compact('drivers'));
    }

    public function store(StoreAmbulanceRequest $request)
    {
        try {
            Ambulance::create([
                'car_model' => $request->post('car_model'),
                'car_year_made' => $request->post('car_year_made'),
                'car_number' => $request->post('car_number'),
                'ownership_status' => $request->ownership_status,
                'driver_id' => $request->post('driver_id'),
                'notes' => $request->post('notes'),
            ]);
            session()->flash('add');
            return redirect()->route('admin.ambulances.index');
        }

        catch (\Exception $e) {
            return redirect()->back()->withErrors([
                'error' => $e->getMessage()
            ]);
        }
    }

    public function edit(string $id)
    {
        $drivers = Driver::with('user.translations')->get(['id', 'user_id']);
        $ambulance = Ambulance::findorfail($id);
        return view('dashboard.ambulances.edit',compact('ambulance', 'drivers'));
    }

    public function update(Request $request)
    {
        $id = $request->post('ambulance_id');
        $request->validate([
            'car_number' => ['required', 'numeric', 'digits_between:5,10',"unique:ambulances,car_number,{$id}"],
            'car_model' => 'required|string|min:2',
            'car_year_made' => 'required|numeric|digits:4',
            'ownership_status' => ['required',Rule::in([0, 1])],
            'driver_id' => 'required|exists:App\Models\Driver,id',
            'notes' => 'nullable|string|min:2',
        ]);
        try {
            $ambulance = Ambulance::findOrFail($id);
            $ambulance->update([
                'car_model' => $request->car_model,
                'car_year_made' => $request->car_year_made,
                'car_number' => $request->car_number,
                'active' => isset($request->active) == 1 ? 1 : 0,
                'ownership_status' => $request->ownership_status,
                'driver_id' => $request->driver_id,
                'notes' => $request->notes,
            ]);
            session()->flash('edit');
            return redirect()->route('admin.ambulances.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors([
                'error' => $e->getMessage()
            ]);
        }
    }

    public function destroy(Request $request)
    {
        Ambulance::destroy($request->ambulance_id);
        session()->flash('delete');
        return redirect()->back();
    }
}
