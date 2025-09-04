<?php

namespace App\Exports;

use App\Models\Student; 
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Http\Request;
use App\Helpers\TeacherExportBuilder;

class TeachersExport implements FromCollection, WithHeadings, WithMapping
{
 


    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // return TeacherExportBuilder::build($this->request)->get();

        $teachers = TeacherExportBuilder::build(request())->get();

        if ($teachers->isEmpty()) {
           throw new \Exception('No data found for export.');

        }

        return $teachers;
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
