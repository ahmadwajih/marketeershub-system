<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advertiser extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function country(){
        return $this->belongsTo(Country::class);
    }
    
    public function city(){
        return $this->belongsTo(City::class);
    }

    public function offers(){
        return $this->hasMany(Offer::class);
    }
}
