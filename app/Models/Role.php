<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    public function users(){
        return $this->belongsTo(User::class);
    }

    public function permissions(){
        return $this->belongsTo(Permission::class);
    }

    public function allowTo($permission){
        return $this->permissions()->save($permission);
    }

    public function disallowTo($permission)
    {
        return $this->permissions()->detach($permission);
    }
}
