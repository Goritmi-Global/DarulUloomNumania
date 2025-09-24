<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Salary extends Model
{
    use SoftDeletes;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'transaction_id',
        'advance_type_id',
        'transaction_date',
        'amount',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->id) {
                $model->id = Str::uuid()->toString();
            }
        });
    }

    // Relations
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

}
