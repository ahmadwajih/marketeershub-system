<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdvertiserCategory extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];
    
    public function getTitleAttribute(){
        return $this->attributes['title_'.app()->getLocale()];
    }

    public function advertisers(){
        return $this->belongsToMany(Advertiser::class);
    }
}
