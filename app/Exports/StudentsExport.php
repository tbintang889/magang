<?php

namespace App\Exports;

use App\Models\Student; 
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Http\Request;
use App\Helpers\StudentExportBuilder;

class StudentsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }


    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // return StudentExportBuilder::build($this->request)->get();

        $students = StudentExportBuilder::build($this->request)->get();

        if ($students->isEmpty()) {
           throw new \Exception('No data found for export.');

        }

        return $students;
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
