<?php

namespace App\Http\Controllers;

use App\Models\Sections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

class SectionsController extends Controller
{
    public function index()
    {
        $sections = Sections::all();
        return view('sections.sections', compact('sections'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'section_name' => 'required|unique:sections|max:255',
        ], [
            'section_name.required' => 'يرجي ادخال اسم القسم',
            'section_name.unique' => 'اسم القسم مسجل مسبقا',
        ]);

        Sections::create([
            'section_name' => $request->section_name,
            'description' => $request->description,
            'created_by' => Auth::user()->name,
        ]);

        session()->flash('Add', 'تم اضافة القسم بنجاح');
        return redirect('/sections');
    }

    public function show(Sections $sections)
    {
        //
    }

    public function edit(Sections $sections)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $sections = Sections::findOrFail($id);
        $request->validate([
            'section_name' => 'required|max:255|unique:sections,section_name,' . $id,
            'description' => 'required',
        ], [
            'section_name.required' => 'يرجي ادخال اسم القسم',
            'section_name.unique' => 'اسم القسم مسجل مسبقا',
            'description.required' => 'يرجي ادخال البيان',
        ]);

        $sections->update([
            'section_name' => $request->section_name,
            'description' => $request->description,
        ]);

        return Redirect::route('sections.index')->with('edit', 'تم تعديل القسم بنجاح');
    }


    public function destroy($id)
    {
        $section = Sections::findOrFail($id);
        $section->delete();

        session()->flash('delete', 'تم حذف القسم بنجاح');
        return redirect()->route('sections.index');
    }
}
