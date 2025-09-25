<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject_name',
        'total_marks',
        'class_id'
    ];

    // Relationship with Class
    public function classModel()
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }
}