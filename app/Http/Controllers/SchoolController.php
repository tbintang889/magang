<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    protected $title;

    public function __construct()
    {
        $this->title ="Sekolah";
    }

    public function index()
    {
        // $schools = School::all();
        $schools = School::paginate(10);
        $title = $this->title;

        $data = [
            'title' => $title,
            'schools' => $schools
        ];
       return view('admin.school.index', $data);
        // dd($schools);
    }

    public function create()
    {
         $title = $this->title;

        $data = [
            'title' => $title
        ];
        return view('admin.school.create', $data);

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
        $title = $this->title;

        return view('admin.school.show', compact('school', 'title'));
    }

    public function edit(School $school)
    {
        $title = $this->title;

        return view('admin.school.edit', compact('school', 'title'));
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