<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Models\User;
class UserQueryBuilder
{
        public static function build(Request $request): Builder
    {
        return User::query()
            ->when($request->filled('role'), fn($q) => $q->role($request->role))
            ->when($request->filled('search'), fn($q) => $q->where('name', 'like', '%' . $request->search . '%'));
    }

}
