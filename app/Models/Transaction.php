<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Transaction extends Model
{
    public $incrementing = false; 
     protected $table = 'transactions';// important for non-auto IDs
    protected $keyType = 'string';

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

   public function salary()
{
    return $this->hasOne(Salary::class, 'transaction_id', 'id');
}

}




