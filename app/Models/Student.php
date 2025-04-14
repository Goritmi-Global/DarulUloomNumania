<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Student extends Model
{
    use HasFactory;

    public $incrementing = false; // Because we are using UUIDs
    protected $keyType = 'string'; // ID is a string (UUID)

    protected $fillable = [
        'id',
        'apply_for',
        'name',
        'father',
        'dob',
        'cnic',
        'country',
        'province',
        'phone_number',
        'whatsapp',
        'guardian_name',
        'guardian_cnic',
        'guardian_mobile',
        'previous_madrasa',
        'previous_class',
        'total_marks',
        'obtained_marks',
        'primary_education',
        'additional_ability',
        'permanent_address',
        'current_address',
        'cnic_front',
        'cnic_back',
        'passport',
        'visa',
        'verification_letter',
    ];

    // Optional: Auto-generate UUID if not set
    protected static function booted()
    {
        static::creating(function ($student) {
            if (empty($student->id)) {
                $student->id = (string) Str::uuid();
            }
        });
    }
}
