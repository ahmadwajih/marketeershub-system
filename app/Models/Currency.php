<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $appends = ['name'];

    public function getNameAttribute(){
        return $this->attributes['name_'. app()->getLocale()];
    }
}
