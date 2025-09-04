<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use App\Models\NumberSequence;

class NumberSequenceManager
{
    public static function next(string $prefix, string $contextKey, int $padding = 3): string
    {
        $sequence = DB::transaction(function () use ($contextKey) {
            $record = NumberSequence::lockForUpdate()->firstOrCreate(
                ['key' => $contextKey],
                ['last_number' => 0]
            );

            $record->last_number += 1;
            $record->save();

            return $record->last_number;
        });

        $number = str_pad($sequence, $padding, '0', STR_PAD_LEFT);
        return "{$prefix}{$number}";
    }
}