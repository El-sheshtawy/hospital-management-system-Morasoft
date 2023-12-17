<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Znck\Eloquent\Traits\BelongsToThrough;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, Translatable, BelongsToThrough;


    protected $fillable = ['email', 'phone_numbers', 'password', 'name'];

    public $translatedAttributes = ['name', 'address'];


    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'phone_numbers' => 'array'
    ];

    //Get the user's image.
    public function image(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
