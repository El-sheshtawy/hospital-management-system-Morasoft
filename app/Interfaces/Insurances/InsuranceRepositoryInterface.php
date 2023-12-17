<?php

namespace App\Interfaces\Insurances;

use App\Http\Requests\StoreInsuranceRequest;
use Illuminate\Http\Request;

interface InsuranceRepositoryInterface
{
    public function index();
    public function create();
    public function store(StoreInsuranceRequest $request);
    public function edit(string $id);
    public function update(Request $request, string $id);
    public function destroy(Request $request);
}
