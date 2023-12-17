<?php

namespace App\Models;

use App\Observers\AnyModelObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'date', 'invoice_id', 'patient_id', 'debit', 'credit', 'receipt_id', 'payment_id',
    ];

    protected static function booted()
    {
        static::observe(AnyModelObserver::class);
    }

    public function singleInvoice()
    {
        return $this->belongsTo(Invoice::class, 'single_invoice_id');
    }

    public function ReceiptAccount()
    {
        return $this->belongsTo(ReceiptAccount::class, 'receipt_id');
    }

    public function paymentAccount()
    {
        return $this->belongsTo(PaymentAccount::class, 'payment_id');
    }
}
