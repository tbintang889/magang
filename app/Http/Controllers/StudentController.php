<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStudentRequest;
use App\Models\School;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Exports\StudentsExport;
use App\Http\Requests\StudentExportRequest;
use Maatwebsite\Excel\Facades\Excel;
use App\Helpers\NumberSequenceManager;
class StudentController extends Controller
{  
    protected $title;

    public function __construct()
    {
        $this->title ="Siswa";
    }
    protected function generateSchoolNumber($school_code): string
    {
        $year = now()->year;
      
        $yearSuffix = substr($year, -2); // "25"
        $contextKey = "Siswa-{$year}-{$school_code}";

        return NumberSequenceManager::next("{$school_code}-{$yearSuffix}", $contextKey);
    }
    public function index()
    {
        // $schools = School::all();
        $students = Student::paginate(10);
        $title = $this->title;
        $data = [
            'students' => $students,
            'title' => $title
        ];

        return view('admin.student.index', $data);
        // dd($schools);
    }
    //
    public function create()
    {


        $schools = School::all();
        $title = $this->title;
        $data = [
            'schools' => $schools,
            'title' => $title
        ];
        return view('admin.student.create', $data);
    }

    public function store(StoreStudentRequest $request)
    {
        $school = School::find($request->input('school_id'));
        $school_code = $school->code;
        $code = $this->generateSchoolNumber($school_code);

        Student::create($request->validated() + ['student_number' => $code]);
        return redirect()->route('students.index')->with('success', 'Student created.');
    }
    //\\
    public function show(Student $student)
    {
        $title = $this->title;
        $data = [
            'student' => $student,
            'title' => $title
        ];
        return view('admin.student.show', $data);
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
    public function export(StudentExportRequest $request)
    {
       return Excel::download(new StudentsExport($request), 'students.xlsx');
    }
}
