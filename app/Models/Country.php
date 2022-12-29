<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];
    protected $appends = ['name'];

    // protected static $relations_to_cascade = ['cities'];
    // protected static function boot(){
    //     parent::boot();
    //     static::deleting(function($resource) {
    //         foreach (static::$relations_to_cascade as $relation) {
    //             foreach ($resource->{$relation}()->get() as $item) {
    //                 $item->delete();
    //             }
    //         }
    //     });

    //     static::restoring(function($resource) {
    //         foreach (static::$relations_to_cascade as $relation) {
    //             $resource->$relation()->withTrashed()->restore();
    //         }
    //     });

    //     static::forceDeleted(function($resource) {
    //         foreach (static::$relations_to_cascade as $relation) {
    //             $resource->$relation()->withTrashed()->forceDelete();
    //         }
    //     });
    // }

    public function getnameAttribute(){
        return $this->attributes['name_'. app()->getLocale()];
    }
    
    public function cities(){
        return $this->hasMany(City::class);
    }

    public function offers(){
        return $this->belongsToMany(Offer::class);
    }
}
