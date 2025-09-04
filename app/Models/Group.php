<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
   protected $fillable = ['code', 'name', 'school_id', 'start_date', 'end_date'];


    public function students()
    {
        return $this->belongsToMany(Student::class, 'group_students');
    }

    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'group_teachers');
    }

    public function documents()
    {
        return $this->hasMany(GroupDocument::class);
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}