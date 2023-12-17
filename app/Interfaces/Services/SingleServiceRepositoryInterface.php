<?php

namespace App\Interfaces\Services;

use App\Http\Requests\StoreSingleServiceRequest;
use Illuminate\Http\Request;

interface SingleServiceRepositoryInterface
{
    public function index();
    public function store(StoreSingleServiceRequest $request);
    public function update(Request $request);
    public function destroy(Request $request);
}