<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'email', 'school_id', 'teacher_number'];

     public function school()
    {
        return $this->belongsTo(School::class);
    }

}
