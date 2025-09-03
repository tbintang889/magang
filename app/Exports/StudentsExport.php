<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class StudentsExport implements FromCollection, WithHeadings, WithMapping
{

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Student::with('school')->get(); // eager load relasi
    }

    public function headings(): array
    {
        return ['Nama', 'Email', 'Sekolah', 'Tanggal Daftar'];
    }

    public function map($student): array
    {
        return [
            $student->name,
            $student->email,
            $student->school?->name ?? 'Tidak ada',
            $student->created_at->format('d-m-Y'),
        ];
    }

}
