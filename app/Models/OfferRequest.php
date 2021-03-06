<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OfferRequest extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];
    
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function offer(){
        return $this->belongsTo(Offer::class);
    }

    public function coupons()
    {
        return $this->hasManyThrough(Coupon::class, User::class);
    }
}
