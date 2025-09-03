<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    public function index()
    {
        // $schools = School::all();
        $schools = School::paginate(10);
       return view('admin.school.index', compact('schools'));
        // dd($schools);
    }

    public function create()
    {
        return view('admin.school.create');

    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'email' => 'nullable|email',
        ]);

        School::create($request->all());
        return redirect()->route('schools.index')->with('success', 'School created.');
    }

    public function show(School $school)
    {
        return view('admin.school.show', compact('school'));
    }

    public function edit(School $school)
    {
        return view('admin.school.edit', compact('school'));
    }

    public function update(Request $request, School $school)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'email' => 'nullable|email',
        ]);

        $school->update($request->all());
        return redirect()->route('schools.index')->with('success', 'School updated.');
    }

    public function destroy(School $school)
    {
        $school->delete();
        return redirect()->route('schools.index')->with('success', 'School deleted.');
    }
}