<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory, Translatable;

    public $translatedAttributes = ['name'];

    public $timestamps = false;

    public function doctors()
    {
        return $this->belongsToMany(Doctor::class, 'appointment_doctor',
            'appointment_id', 'doctor_id', 'id', 'id');
    }
}
