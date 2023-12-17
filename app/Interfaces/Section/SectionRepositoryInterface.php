<?php

namespace App\Interfaces\Section;

use App\Http\Requests\StoreSectionRequest;
use Illuminate\Http\Request;


interface SectionRepositoryInterface
{
    public function index();
    public function store(StoreSectionRequest $request);
    public function update(Request $request);
    public function destroy(Request $request);
    public function showDoctors($id);
}
