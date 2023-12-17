<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Insurance extends Model
{
    use HasFactory, Translatable;

    protected $fillable = [
        'insurance_code', 'discount_percentage', 'percentage_costs_insurance', 'active', 'updated_at',
    ];

    public $translatedAttributes = [
        'name', 'notes',
    ];
}
