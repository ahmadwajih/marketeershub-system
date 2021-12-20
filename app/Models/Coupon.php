<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = [];


    public function offer(){
        return $this->belongsTo(Offer::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function report(){
        return $this->hasOne(PivotReport::class);
    }
}
