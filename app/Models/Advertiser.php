<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Advertiser extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = [];

    public function country(){
        return $this->belongsTo(Country::class);
    }

    public function currency(){
        return $this->belongsTo(Currency::class);
    }
    
    public function city(){
        return $this->belongsTo(City::class);
    }

    public function offers(){
        return $this->hasMany(Offer::class);
    }
    
    public function getCompanyNameAttribute(){
        return $this->attributes['company_name_'.app()->getLocale()];
    }

    public function categories(){
        return $this->belongsToMany(AdvertiserCategory::class);
    }
}
