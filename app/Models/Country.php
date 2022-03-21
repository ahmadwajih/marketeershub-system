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
