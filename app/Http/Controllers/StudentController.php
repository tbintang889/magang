<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStudentRequest;
use App\Models\School;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Exports\StudentsExport;
use Maatwebsite\Excel\Facades\Excel;

class StudentController extends Controller
{
    public function index()
    {
        // $schools = School::all();
        $students = Student::paginate(10);
        return view('admin.student.index', compact('students'));
        // dd($schools);
    }
    //
    public function create()
    {

        $schools = School::all();
        return view('admin.student.create', compact('schools'));
    }

    public function store(StoreStudentRequest $request)
    {

        Student::create($request->validated());
        return redirect()->route('students.index')->with('success', 'Student created.');
    }
    //\\
    public function show(Student $student)
    {
        return view('admin.student.show', compact('student'));
    }

    public function edit(Student $student)
    {
        $schools = School::all();
        $data = [
            'student' => $student,
            'schools' => $schools
        ];
        return view('admin.student.edit', $data);
    }

    public function update(Request $request, Student $student)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email,' . $student->id,

        ]);

        $student->update($request->all());
        return redirect()->route('students.index')->with('success', 'Student updated.');
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('students.index')->with('success', 'Student deleted.');
    }
    public function export()
    {
        return Excel::download(new StudentsExport, 'students.xlsx');
    }
}
