<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Ray extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id', 'patient_id', 'doctor_id', 'doctor_description',
        'rays_employee_id', 'rays_employee_description', 'status',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }

    public function rayEmployee()
    {
        return $this->belongsTo(RayEmployee::class, 'ray_employee_id');
    }

    public function images():MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
