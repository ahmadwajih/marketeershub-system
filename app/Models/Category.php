<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $guarded = [];
    protected $appends = ['title'];
    
    public function getTitleAttribute(){
        return $this->attributes['title_'.app()->getLocale()];
    }
    
    public function offers(){
        return $this->BelongsToMany(Offer::class);
    }
}
