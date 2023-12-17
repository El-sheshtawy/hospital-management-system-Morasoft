<?php

namespace App\Models;

use App\Observers\AnyModelObserver;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SingleService extends Model
{
    use HasFactory, Translatable;
    protected $fillable = [
        'price', 'active',
    ];

    public $translatedAttributes = [
        'name', 'description',
    ];

    protected static function booted()
    {
        static::observe(AnyModelObserver::class);
    }

    public function translation()
    {
        return $this->hasMany(SingleServiceTranslation::class, 'service_id');
    }
}
