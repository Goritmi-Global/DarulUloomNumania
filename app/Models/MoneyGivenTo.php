<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class MoneyGivenTo extends Model
{
    use HasFactory;
    public $incrementing=false;
    protected $table = 'money_give_to';
    
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->id = (string) Str::orderedUuid();
        });
    }
    public function money_give_to()
    {
        return $this->hasMany(Peron::class, 'person_id');
    }
}

