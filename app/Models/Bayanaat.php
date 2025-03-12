<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Bayanaat extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['title', 'author', 'islamic_date', 'english_date', 'content'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($bayanaat) {
            $bayanaat->id = Str::orderedUuid();
        });
    }
}
