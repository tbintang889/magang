<?php

namespace App\Http\Requests;

use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Teacher;

class AddGroupMemberRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'member_ids' => 'required|array|min:1',
            'member_ids.*' => 'integer',
        ];
    }

    public function withValidator($validator)
{
    $validator->after(function ($validator) {
        $group = $this->route('group');
        $schoolId = $group->school_id;
        
        $memberIds = $this->member_ids ?? []; // Prevent null

        if ($this->routeIs('groups.addStudents')) {
            $invalid = Student::whereIn('id', $memberIds)
                ->where('school_id', '!=', $schoolId)
                ->exists();
            if ($invalid) {
                $validator->errors()->add('member_ids', 'Semua siswa harus dari sekolah yang sama dengan group.');
            }
        }

        if ($this->routeIs('groups.addTeachers')) {
            $invalid = Teacher::whereIn('id', $memberIds)
                ->where('school_id', '!=', $schoolId)
                ->exists();
            if ($invalid) {
                $validator->errors()->add('member_ids', 'Semua guru harus dari sekolah yang sama dengan group.');
            }
        }
    });
}

}
