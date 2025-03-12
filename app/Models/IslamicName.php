<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class IslamicName extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['name', 'meaning', 'roman', 'inflection', 'type', 'reference'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($islamicName) {
            $islamicName->id = Str::orderedUuid();
        });
    }
}
