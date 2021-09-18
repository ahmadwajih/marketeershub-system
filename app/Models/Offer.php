<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    public function advertiser(){
        return $this->belongsTo(Advertiser::class);
    }

    public function currency(){
        return $this->belongsTo(Currency::class);
    }
}
