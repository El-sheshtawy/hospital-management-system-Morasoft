<?php

namespace App\Repositories\Insurances;

use App\Http\Requests\StoreInsuranceRequest;
use App\Interfaces\Insurances\InsuranceRepositoryInterface;
use App\Models\Insurance;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;


class InsuranceRepository implements InsuranceRepositoryInterface
{

    public function index()
    {
        $insurances = Insurance::all();
        return view('dashboard.insurances.index', compact('insurances'));
    }

    public function create()
    {
        return view('dashboard.insurances.create');
    }

    public function store(StoreInsuranceRequest $request)
    {
        try {
            Insurance::create([
                'name' => $request->post('name'),
                'notes' => $request->post('notes'),
                'insurance_code' => $request->post('insurance_code'),
                'discount_percentage' => $request->post('discount_percentage'),
                'percentage_costs_insurance' => $request->post('percentage_costs_insurance'),
                'updated_at' => null,
            ]);
            session()->flash('add');
            return redirect()->route('admin.insurances.index');
        }
        catch (\Exception $e) {
            return redirect()->back()->withErrors([
                'error' => $e->getMessage()
            ]);
        }
    }

    public function edit(string $id)
    {
        $insurance = Insurance::findOrFail($id);
        return view('dashboard.insurances.edit', compact('insurance'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => "required|unique:insurance_translations,name,{$id}",
            'insurance_code' => 'required',
            'discount_percentage' =>'required|numeric',
            'percentage_costs_insurance' =>'required|numeric',
        ]);
        try {
            $insurence = Insurance::findOrFail($id);
            $insurence->update([
                'name' => $request->post('name'),
                'notes' => $request->post('notes'),
                'insurance_code' => $request->post('insurance_code'),
                'discount_percentage' => $request->post('discount_percentage'),
                'percentage_costs_insurance' => $request->post('percentage_costs_insurance'),
                'active' => isset($request->active) == 1 ? 1 : 0,
                'updated_at' => Carbon::now(),
            ]);
            session()->flash('edit');
            return redirect()->route('admin.insurances.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors([
                'error' => $e->getMessage()
            ]);
        }
    }

    public function destroy(Request $request)
    {
        Insurance::destroy($request->insurance_id);
        session()->flash('delete');
        return redirect()->route('admin.insurances.index');
    }
}