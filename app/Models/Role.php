<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $guarded = [];

    public function users(){
        return $this->belongsToMany(User::class);
    }

    public function abilities(){
        return $this->belongsToMany(Ability::class);
    }

    public function allowTo($ability){
        return $this->abilities()->save($ability);
    }

    public function disallowTo($ability)
    {
        return $this->abilities()->detach($ability);
    }
}
