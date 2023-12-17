<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhoneNumber extends Model
{
    use HasFactory;

    protected $fillable = [
        'numbers', 'phoneable_id', 'phoneable_type',
    ];

    protected $casts = [
        'numbers' => 'array'
    ];


    public function phoneable()
    {
        return $this->morphTo();
    }
}
