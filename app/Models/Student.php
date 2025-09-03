<?php

namespace App\Models;

use App\Models\School;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Student extends Model
{
   use HasFactory, LogsActivity;

    protected $fillable = ['name', 'email', 'school_id'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'email', 'school_id'])
            ->useLogName('student');
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    protected static $logAttributes = ['name', 'email', 'school_id'];
    protected static $logName = 'student';

}