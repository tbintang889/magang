<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Models\Teacher;

class TeacherExportBuilder
{
    public static function build(Request $request): Builder
    {
        return Teacher::query()
            ->when($request->filled('school_id'), fn($q) => $q->where('school_id', $request->school_id))
            ->when($request->filled('class'), fn($q) => $q->where('class', $request->class))
            ->when($request->filled('status'), fn($q) => $q->where('status', $request->status));
    }
}