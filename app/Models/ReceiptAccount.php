<?php

namespace App\Models;

use App\Observers\AnyModelObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceiptAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'date', 'patient_id', 'amount', 'description'
    ];

    protected static function booted()
    {
     static::observe(AnyModelObserver::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }
}
