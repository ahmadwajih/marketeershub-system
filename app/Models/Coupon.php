<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static count()
 * @method static findOrFail(mixed $id)
 */
class Coupon extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = [];

    protected static $relations_to_cascade = ['cps'];
    protected static function boot(){
        parent::boot();
        static::deleting(function($resource) {
            foreach (static::$relations_to_cascade as $relation) {
                foreach ($resource->{$relation}()->get() as $item) {
                    $item->delete();
                }
            }
        });

        static::restoring(function($resource) {
            foreach (static::$relations_to_cascade as $relation) {
                $resource->$relation()->withTrashed()->restore();
            }
        });

        static::forceDeleted(function($resource) {
            foreach (static::$relations_to_cascade as $relation) {
                $resource->$relation()->withTrashed()->forceDelete();
            }
        });
    }


    public function offer(){
        return $this->belongsTo(Offer::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function reports(){
        return $this->hasMany(PivotReport::class);
    }

    public function report(){
        return $this->hasOne(PivotReport::class);
    }

    public function cps(){
        return $this->hasMany(CouponCps::class);
    }
}
