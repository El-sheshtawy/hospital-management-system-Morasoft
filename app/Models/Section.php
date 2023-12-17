<?php

namespace App\Models;

use App\Observers\AnyModelObserver;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory, Translatable;

    public $translatedAttributes = ['name', 'description'];

    protected static function booted()
    {
        static::observe(AnyModelObserver::class);
    }
}
