<?php

namespace App\Models;

use App\Observers\AnyModelObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FundAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'date', 'invoice_id', 'debit', 'credit', 'receipt_id', 'payment_id',
    ];

    protected static function booted()
    {
        static::observe(AnyModelObserver::class);
    }
}

