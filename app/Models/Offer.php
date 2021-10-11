<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function advertiser(){
        return $this->belongsTo(Advertiser::class);
    }

    public function currency(){
        return $this->belongsTo(Currency::class);
    }

    public function countries(){
        return $this->belongsToMany(Country::class)->withTimestamps();
    }

    public function coupons(){
        return $this->hasMany(Coupon::class);
    }

    public function allowTo($contry){
        return $this->countries()->save($contry);
    }

    public function disallowTo($contry)
    {
        return $this->countries()->detach($contry);
    }
}
