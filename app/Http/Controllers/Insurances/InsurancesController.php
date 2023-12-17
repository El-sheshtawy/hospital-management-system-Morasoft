<?php

namespace App\Http\Controllers\Insurances;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreInsuranceRequest;
use App\Interfaces\Insurances\InsuranceRepositoryInterface;
use Illuminate\Http\Request;

class InsurancesController extends Controller
{
    private InsuranceRepositoryInterface $insuranceRepository;

    public function __construct(InsuranceRepositoryInterface $insuranceRepository)
    {
        $this->insuranceRepository = $insuranceRepository;
    }

    public function index()
    {
        return $this->insuranceRepository->index();
    }

    public function create()
    {
        return $this->insuranceRepository->create();
    }

    public function store(StoreInsuranceRequest $request)
    {
        return $this->insuranceRepository->store($request);
    }


    public function edit(string $id)
    {
        return $this->insuranceRepository->edit($id);
    }

    public function update(Request $request, $id)
    {
        return $this->insuranceRepository->update($request, $id);
    }

    public function destroy(Request $request)
    {
        return $this->insuranceRepository->destroy($request);
    }
}
