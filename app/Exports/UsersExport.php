<?php
namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Http\Request;
use App\Helpers\UserQueryBuilder;
class UsersExport implements FromCollection, WithHeadings, WithMapping
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        return UserQueryBuilder::build($this->request)->get();
    }

    public function headings(): array
    {
        return ['Name', 'Email', 'Role', 'Created At'];
    }

    public function map($user): array
    {
        return [
            $user->name,
            $user->email,
            $user->getRoleNames()->join(', '),
            $user->created_at->format('d-m-Y'),
        ];
    }
}