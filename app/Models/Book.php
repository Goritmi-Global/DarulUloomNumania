<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Book extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['title', 'description', 'image', 'download_link'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($book) {
            $book->id = Str::orderedUuid();
        });
    }
}
