<?php

namespace App\Models;

use App\Observers\AnyModelObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentAccount extends Model
{
    use HasFactory;
    protected $fillable = [
        'date', 'patient_id', 'amount', 'description', 'payment_id',
    ];


    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }
}
