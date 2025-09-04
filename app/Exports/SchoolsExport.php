<?php

namespace App\Exports;

use App\Models\School; 
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Http\Request;
use App\Helpers\SchoolExportBuilder;

class SchoolsExport implements FromCollection, WithHeadings, WithMapping
{
   


    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // return SchoolExportBuilder::build($this->request)->get();

        $Schools = School::all();

        if ($Schools->isEmpty()) {
           throw new \Exception('No data found for export.');

        }

        return $Schools;
    }

    public function headings(): array
    {
        return ['Nama', 'Alamat', 'Email'];
    }

    public function map($School): array
    {
        return [
            $School->name,
            $School->address,
            $School->email,
     
        ];
    }

}
