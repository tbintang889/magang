<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class GroupDocument extends Model
{
    protected $table = 'group_documents';
    protected $fillable = ['group_id', 'file_path', 'file_name', 'file_type'];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}