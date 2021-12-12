<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PublisherCategory extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $guarded = [];
    
    public function offers(){
        return $this->BelongsToMany(Offer::class);
    }
    
}
