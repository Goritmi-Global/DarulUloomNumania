<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OperatingAdvance extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'designation', 'contact'];
    public $incrementing = false;
    protected $keyType = 'string';
}
