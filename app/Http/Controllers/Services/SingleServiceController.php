<?php

namespace App\Http\Controllers\Services;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSingleServiceRequest;
use App\Interfaces\Services\SingleServiceRepositoryInterface;
use Illuminate\Http\Request;

class SingleServiceController extends Controller
{
    private SingleServiceRepositoryInterface $singleServiceRepository;

    public function __construct(SingleServiceRepositoryInterface $singleServiceRepository)
    {
       return $this->singleServiceRepository = $singleServiceRepository;
    }

    public function index()
    {
        return $this->singleServiceRepository->index();
    }

    public function store(StoreSingleServiceRequest $request)
    {
        return $this->singleServiceRepository->store($request);
    }

    public function update(Request $request)
    {
        return $this->singleServiceRepository->update($request);
    }

    public function destroy(Request $request)
    {
        return $this->singleServiceRepository->destroy($request);
    }
}
