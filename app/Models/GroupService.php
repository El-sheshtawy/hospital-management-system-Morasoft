<?php

namespace App\Models;

use App\Observers\AnyModelObserver;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GroupService extends Model
{
    use HasFactory, Translatable;

    protected $fillable = [
        'total_before_discount',
        'discount_value', 'total_after_discount', 'tax_rate', 'total_with_tax',
    ];
    public $translatedAttributes = [
        'name', 'description',
    ];

    protected static function booted()
    {
        static::observe(AnyModelObserver::class);
    }

    public function group_service()
    {
        return $this->belongsToMany(SingleService::class, 'group_pivot_service')
            ->withPivot('quantity');
    }

    public function translations()
    {
       return $this->hasMany(GroupServiceTranslation::class, 'group_service_id');
    }
}
