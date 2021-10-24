<?php

namespace App\Models;
//161.35.27.113
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Offer extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $guarded = [];

    public function advertiser(){
        return $this->belongsTo(Advertiser::class);
    }

    public function currency(){
        return $this->belongsTo(Currency::class);
    }
  
    public function coupons(){
        return $this->hasMany(Coupon::class);
    }

    public function countries(){
        return $this->belongsToMany(Country::class)->withTimestamps();
    }

    public function assignCountry($contry){
        return $this->countries()->save($contry);
    }

    public function unassignCountry($contry)
    {
        return $this->countries()->detach($contry);
    }

    public function categories(){
        return $this->belongsToMany(Category::class)->withTimestamps();
    }

    public function assignCategory($category){
        return $this->categories()->save($category);
    }

    public function unassignCategory($category)
    {
        return $this->categories()->detach($category);
    }

    public function newOld(){
        return $this->hasOne(NewOldOffer::class);
    }

    public function slaps(){
        return $this->hasMany(OfferSlap::class);
    }

    public function users(){
        return $this->belongsToMany(User::class)->withTimestamps();
    }
}
