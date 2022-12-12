<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static findOrFail(int $id)
 */
class PivotReport extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function offer(){
        return $this->belongsTo(Offer::class);
    }

    public function coupon(){
        return $this->belongsTo(Coupon::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

}
