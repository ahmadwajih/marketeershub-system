<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SallaInfo extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];
    
    public function offer(){
        return $this->belongsTo(Offer::class);
    }
}
