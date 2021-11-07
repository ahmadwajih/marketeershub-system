<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserActivity extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];
    public $appends  = ['element'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function getCreatedAtAttribute()
    {
        return Carbon::createFromTimeStamp(strtotime($this->attributes['created_at']) )->diffForHumans();
    }

    public function getElementAttribute()
    {
        if($this->attributes['object_id']){
            $model = "App\Models\\".$this->attributes['object']; 
            $model = $model::withTrashed()->find($this->attributes['object_id']);    
            $routeName = lcfirst(Str::plural($this->attributes['object']));            
            return  route('admin.'.$routeName.'.show', $this->attributes['object_id']);
        }
        return false;




    }
}
