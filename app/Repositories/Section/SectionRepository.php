<?php

namespace App\Repositories\Section;

use App\Events\MyEvent;
use App\Interfaces\Section\SectionRepositoryInterface;
use App\Models\Section;
use App\Http\Requests\StoreSectionRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SectionRepository implements SectionRepositoryInterface
{

    public function index()
    {
        event(new MyEvent('Hello Admin : '.auth()->user()->name, auth()->user()->name . ' show all sections'));
        $sections = Section::withTranslation()->get(['id', 'created_at', 'updated_at']);
        return view('dashboard.sections.index',compact('sections'));
    }

    public function store(StoreSectionRequest $request)
    {
        Section::create([
            'name' => $request->post('name'),
            'description' => $request->post('description'),
        ]);

        session()->flash('add');
        return redirect()->route('admin.sections.index');
    }

    public function update(Request $request)
    {
        $section = Section::findOrFail($request->post('section_id'));
        $section->update([
            'name' => $request->input('name'),
            'description' => $request->post('description'),
        ]);
        session()->flash('edit');
        return redirect()->route('admin.sections.index');
    }

    public function destroy(Request $request)
    {
        Section::findOrFail($request->post('section_id'))->delete();
        session()->flash('delete');
        return redirect()->route('admin.sections.index');
    }

    public function showDoctors($id)
    {
        $section = Section::findOrFail($id)->load('doctors');
        return view('dashboard.sections.show-doctors', compact('section'));
    }
}
