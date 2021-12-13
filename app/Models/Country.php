<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;
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
