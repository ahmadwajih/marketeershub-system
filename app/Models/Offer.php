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
}
