<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassModel extends Model
{
    use HasFactory;

    protected $table = 'classes';

    protected $fillable = ['class_name'];

    // Relationship with Subjects
    public function subjects()
    {
        return $this->hasMany(Subject::class, 'class_id');
    }

       public function students()
    {
        // assuming students.class_id is the FK to classes.id
        return $this->hasMany(\App\Models\Student::class, 'class_id', 'id');
    }
    
}