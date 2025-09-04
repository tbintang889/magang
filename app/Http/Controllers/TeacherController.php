<?php

namespace App\Http\Controllers;


use App\Exports\TeachersExport;
use App\Helpers\NumberSequenceManager;
use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class TeacherController extends Controller
{
        protected $title;

    public function __construct()
    {
        $this->title ="Guru";
    }
     protected function generateTeacherNumber($school_code): string
    {
        $year = now()->year;
      
        $yearSuffix = substr($year, -2); // "25"
        $contextKey = "Guru-{$year}-{$school_code}";

        return NumberSequenceManager::next("T-{$school_code}-{$yearSuffix}", $contextKey);
    }

    public function index()
    {
        // $teachers = Teacher::all();
        $teachers = Teacher::paginate(10);
        $title = $this->title;

        $data = [
            'title' => $title,
            'teachers' => $teachers
        ];
       return view('admin.teacher.index', $data);
        // dd($teachers);
    }

    public function create()
    {
         $title = $this->title;
         $schools = School::all();
        $data = [
            'title' => $title,
            'schools' => $schools
        ];
        return view('admin.teacher.create', $data);

    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'email' => 'nullable|email',
        ]);
        
        $school = School::find($request->input('school_id'));
        $school_code = $school->code;
        $code = $this->generateTeacherNumber($school_code);
        $request->merge(['teacher_number' => $code]);

        Teacher::create($request->all());
        return redirect()->route('teachers.index')->with('success', 'Teacher created.');
    }

    public function show(Teacher $teacher)
    {
        $title = $this->title;

        return view('admin.teacher.show', compact('teacher', 'title'));
    }

    public function edit(Teacher $teacher)
    {
        $title = $this->title;
        $schools = School::all();
        return view('admin.teacher.edit', compact('teacher', 'title', 'schools'));
    }

    public function update(Request $request, Teacher $teacher)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'email' => 'nullable|email',
        ]);

        $teacher->update($request->all());
        return redirect()->route('teachers.index')->with('success', 'Teacher updated.');
    }

    public function destroy(Teacher $teacher)
    {
        $teacher->delete();
        return redirect()->route('teachers.index')->with('success', 'Teacher deleted.');
    }
    public function export()
    {
       return Excel::download(new TeachersExport, 'Teachers.xlsx');
    }
}
