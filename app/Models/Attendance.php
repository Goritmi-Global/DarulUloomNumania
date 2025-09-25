<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    // Explicitly define the table name if it's not the default "attendances"
    protected $table = 'attendances';

    protected $fillable = [
        'student_id',
        'class_id',
        'attendance_date',
        'status',
    ];
}
