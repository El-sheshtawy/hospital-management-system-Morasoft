<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSectionRequest;
use App\Interfaces\Section\SectionRepositoryInterface;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    private SectionRepositoryInterface $section;

    public function __construct(SectionRepositoryInterface $section)
    {
        $this->section = $section;
    }

    public function index()
    {
       return $this->section->index();
    }

    public function store(StoreSectionRequest $request)
    {
        return $this->section->store($request);
    }

    public function update(Request $request)
    {
        return $this->section->update($request);
    }

    public function destroy(Request $request)
    {
        return $this->section->destroy($request);
    }

    public function showDoctors($id)
    {
      return $this->section->showDoctors($id);
    }
}
