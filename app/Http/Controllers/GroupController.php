<?php

namespace App\Http\Controllers;


use App\Helpers\NumberSequenceManager;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddGroupMemberRequest;
use App\Http\Requests\GroupStoreRequest;
use App\Models\Group;

use App\Models\GroupDocument;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GroupController extends Controller
{
    protected $title;

    public function __construct()
    {
        $this->title = "Group Management";
    }
    protected function generateGroupNumber($schoolCode): string
    {
        $year = now()->year;
        $yearSuffix = substr($year, -2); // "25"
        $contextKey = "group-{$year}";

        return NumberSequenceManager::next("GR{$schoolCode}-{$yearSuffix}", $contextKey);
    }

    public function index()
    {
        // $groups = Group::all();
        $groups = Group::paginate(10);
        $title = $this->title;
        $schools = School::all();
        $data = [
            'title' => $title,
            'groups' => $groups,
            'schools' => $schools
        ];
        return view('admin.group.index', $data);
        // dd($groups);
    }

    public function create()
    {
        $title = $this->title;
        $schools = School::all();
        $data = [
            'title' => $title,
            'schools' => $schools
        ];
        return view('admin.group.create', $data);
    }

    public function store(GroupStoreRequest  $request)
    {
        $data = $request->validated();

        $school = School::find($request->input('school_id'));
        $school_code = $school->code;
        $code = $this->generateGroupNumber($school_code);
        $data['code'] = $code;
        $group = Group::create($data);

        return redirect()->route('groups.show', $group)->with('success', 'Group berhasil dibuat.');
    }

    public function addStudents(AddGroupMemberRequest $request, Group $group)
    {
        $memberIds = is_array($request->member_ids) ? $request->member_ids : [];
        $group->students()->syncWithoutDetaching($memberIds);

        return redirect()->route('groups.show', $group)->with('success', 'Group berhasil dibuat.');
    }

    public function addTeachers(AddGroupMemberRequest $request, Group $group)
    {
        $group->teachers()->syncWithoutDetaching($request->member_ids);
        return redirect()->route('groups.show', $group)->with('success', 'Guru berhasil ditambahkan.');
    }

    public function formStudents(Group $group)
    {
        $title = $this->title;
        $schoolId = $group->school_id;
        $members = School::find($schoolId)->students;
        $selectedMemberIds = $group->students()->pluck('students.id')->toArray();
        $action = 'groups.addStudents';
        return view('admin.group.form_members', compact('group', 'members', 'title', 'action', 'selectedMemberIds'));
    }

    public function formTeachers(Group $group)
    {
        $title = $this->title;
        $schoolId = $group->school_id;
        $members = School::find($schoolId)->teachers;
        $selectedMemberIds = $group->teachers()->pluck('teachers.id')->toArray();
        $action = 'groups.addTeachers';
        return view('admin.group.form_members', compact('group', 'members', 'title', 'action', 'selectedMemberIds'));
    }
    //storeDocument
    public function storeDocument(Request $request, Group $group)
    {
        // 1️⃣ Validasi — kalau gagal, otomatis throw ValidationException
        $validated = $request->validate([
            'file_name' => 'required|string|max:255',
            'file'      => 'required|file|mimes:pdf,doc,docx,image|max:2048',
        ]);

        // 2️⃣ Buat model
        $document = new GroupDocument();
        $document->file_name = $validated['file_name'];
        $document->group_id  = $group->id;

        // 3️⃣ Upload file — kalau gagal, langsung throw
        if (!$request->hasFile('file')) {
            throw new \RuntimeException('File tidak ditemukan pada request.');
        }

        $path = $request->file('file')->store('documents', 'public');
        if (!$path) {
            throw new \RuntimeException('Gagal menyimpan file ke storage.');
        }
        $document->file_path = $path;
        $document->file_type = $request->file('file')->getClientMimeType();
        // 4️⃣ Simpan database — kalau gagal, langsung throw
        if (!$document->save()) {
            throw new \RuntimeException('Gagal menyimpan data dokumen ke database.');
        }

        // 5️⃣ Pastikan record baru
        if (!$document->wasRecentlyCreated) {
            throw new \RuntimeException('Dokumen gagal ditambahkan (record tidak baru).');
        }

        // // ✅ Sukses
        return redirect()
            ->route('groups.show', $group)
            ->with('success', 'Dokumen berhasil ditambahkan.');
    }

    public function show(Group $group)
    {
        $title = $this->title;
        $school = School::find($group->school_id);
        return view('admin.group.show', compact('group', 'title', 'school'));
    }

    public function edit(Group $group)
    {
        $title = $this->title;
        $schools = School::all();

        return view('admin.group.edit', compact('group', 'title', 'schools'));
    }

    public function update(Request $request, Group $group)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'email' => 'nullable|email',
        ]);

        $group->update($request->all());
        return redirect()->route('groups.index')->with('success', 'Group updated.');
    }

    public function destroy(Group $group)
    {
        $group->delete();
        return redirect()->route('groups.index')->with('success', 'Group deleted.');
    }
    public function export()
    {
        //    return Excel::download(new GroupsExport, 'Groups.xlsx');
    }
    public function destroyDocument(Group $group, $id)
    {
        $document = GroupDocument::findOrFail($id);
        
        echo $id;
        // Hapus file dari storage
        if (Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }
        
        
        // Hapus record dari database
        //cek apakah berhasil
        if ($document->delete()) {
            return redirect()
                ->route('groups.show', $document->group) // kirim model langsung
                ->with('success', 'Dokumen berhasil dihapus.');
        }else{
            // throw new \RuntimeException('Dokumen gagal dihapus.');
        }

       
    }
}
