<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Models\Student;

class StudentExportBuilder
{
    public static function build(Request $request): Builder
    {
        return Student::query()
            ->when($request->filled('school_id'), fn($q) => $q->where('school_id', $request->school_id))
            ->when($request->filled('class'), fn($q) => $q->where('class', $request->class))
            ->when($request->filled('status'), fn($q) => $q->where('status', $request->status));
    }
}