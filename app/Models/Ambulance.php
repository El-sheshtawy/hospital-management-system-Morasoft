<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Znck\Eloquent\Traits\BelongsToThrough;

class Ambulance extends Model
{
    use HasFactory, Translatable, BelongsToThrough;

    protected $fillable = ['car_model', 'car_year_made', 'car_number', 'active', 'ownership_status', 'driver_id'];

    public $translatedAttributes = ['notes'];

//    public const OWNERSHIP_STATUSES = [
//        0 => 'rented',
//        1 => 'owned',
//    ];
//
//    public static function getOwnershipStatus($status)    // return 0 or 1
//    {
//        return array_search($status, self::OWNERSHIP_STATUSES);
//    }
//
//    public function getOwnershipStatusAttribute()         // return rented or owned
//    {
//        return self::OWNERSHIP_STATUSES[$this->attributes['ownership_status']];
//    }
//
//    public function setOwnershipStatusAttribute($value)
//    {
//        $status = self::getOwnershipStatus($value);
//        if ($status) {
//            $this->attributes['ownership_status'] = $status;
//        }
//    }

    public function user()
    {
       return $this->belongsToThrough(User::class, Driver::class);
    }
}
