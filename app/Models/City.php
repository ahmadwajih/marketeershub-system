<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $appends = ['name'];

    public function getnameAttribute(){
        return $this->attributes['name_'. app()->getLocale()];
    }
    
    public function country(){
        return $this->belongsTo(Country::class);
    }
}
