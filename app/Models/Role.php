<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

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
