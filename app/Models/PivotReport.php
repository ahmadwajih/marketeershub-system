<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PivotReport extends Model
{
    use HasFactory;
    protected $guarded = [];
    
    public function coupon(){
        return $this->belongsTo(Coupon::class);
    }

}
