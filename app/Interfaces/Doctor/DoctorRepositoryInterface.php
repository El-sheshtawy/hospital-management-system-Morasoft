<?php

namespace App\Interfaces\Doctor;

use App\Http\Requests\StoreDoctorRequest;
use App\Http\Requests\UpdateDoctorPassworRequest;
use Illuminate\Http\Request;

interface DoctorRepositoryInterface
{
    public function index();
    public function create();
    public function store(StoreDoctorRequest $request);
    public function edit(string $id);
    public function update(Request $request, string $id);
    public function destroy(Request $request);
    public function updatePassword(UpdateDoctorPassworRequest $request);
    public function updateStatus(Request $request);
}
