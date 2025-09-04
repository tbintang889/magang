<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'address', 'email','code'];
    
    public function groups()
    {
        return $this->hasMany(Group::class);
    }
    // Relationship with students
    public function students()
    {
        return $this->hasMany(Student::class);
    }
    // Relationship with teachers
    public function teachers()
    {
        return $this->hasMany(Teacher::class);
    }

}
