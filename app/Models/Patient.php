<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Patient extends Model
{
    use HasFactory, HasRoles;

    protected $fillable = ['user_id', 'birth_date', 'gender', 'blood_type', 'address', 'uuid'];


    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) \Uuid::generate(4);
        });
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }


//    public const GENDER = [
//        0 => 'female',
//        1 => 'male',
//    ];
//
//    public const BLOOD_TYPES = [
//       1 => '+O', 2 => '-O', 3 =>'+A', 4 => '-A',
//        5 => '+B', 6 => '-B', 7 => '+AB', 8 => '-AB',
//    ];
//
//    public function getGender($gender)  // return 0 or 1
//    {
//        return array_search($gender, self::GENDER);
//    }
//
//    public function getGenderAttribute($gender)
//    {
//        return self::GENDER[$this->attributes['gender']];
//    }
//
//    public function setGenderAttribte($value)
//    {
//        $gender = self::getGender($value);
//        if ($gender) {
//            $this->attributes['gender'] = $gender;
//        }
//    }
//
//    public function getBloodType($bloodType)
//    {
//        return array_search($bloodType, self::BLOOD_TYPES);
//    }
//
//    public function getBloodTypeAttribute($bloodType)
//    {
//        return self::BLOOD_TYPES[$this->attributes['blood_type']];
//    }
//
//    public function setBloodTypeAttribute($value)
//    {
//        $blood_type = self::getBloodType($value);
//        if ($blood_type) {
//            $this->attributes['blood_type'] = $blood_type;
//        }
//    }
}
