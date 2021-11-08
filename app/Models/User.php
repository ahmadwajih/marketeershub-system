<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $guarded = [];
    public $appends = ['socialLinks', 'offersCount', 'sumOrders'];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roles(){
        return $this->belongsToMany(Role::class)->withTimestamps();
    }

    public function parent(){
        return $this->belongsTo(User::class, 'parent_id')->with('parent');
    }

    public function childrens(){
        return $this->hasMany(User::class, 'parent_id');
    }


    public function assignRole($role_id)
    {
        return $this->roles()->save($role_id);
    }

    public function abilities()
    {
        return $this->roles->map->abilities->flatten()->pluck('name')->unique();
    }

    public function country(){
        return $this->belongsTo(Country::class);
    }

    public function city(){
        return $this->belongsTo(City::class);
    }

    public function coupons(){
        return $this->hasMany(Coupon::class);
    }

    public function offers(){
        return $this->belongsToMany(Offer::class);
    }

    public function assignOffer($offerId)
    {
        return $this->offers()->save($offerId);
    }
    public function unAssignOffer($offerId)
    {
        return $this->offers()->detach($offerId);
    }

    
    public function categories(){
        return $this->belongsToMany(Category::class)->withTimestamps();
    }

    public function assignCategory($category){
        return $this->categories()->save($category);
    }

    public function unassignCategory($category)
    {
        return $this->categories()->detach($category);
    }
    

    public function getUpdatedTeamAttribute(){
        return ucwords(str_replace('_', ' ', $this->attributes['team']));
    }

    public function getUpdatedPositionAttribute(){
        return ucwords(str_replace('_', ' ', $this->attributes['position']));
    }

    public function socialMediaLinks(){
        return $this->hasMany(SocialMediaLink::class);
    }

    public function getSocialLinksAttribute(){
        $links = [];
        foreach($this->socialMediaLinks as $link ){
            $links[] = $link;
        }
        return $links;
    }

    public function getOffersCountAttribute(){
        return $this->offers()->whereStatus('active')->count();
    }

    public function getSumOrdersAttribute() 
    {
        $orders = $this->coupons->map(function ($coupon){
            return $coupon->report()->whereMonth(
                'created_at', '>', Carbon::now()->subMonth()->month
            )->get();
        })->flatten();
        $sumoforders =  $orders->sum('orders');
        if($sumoforders > 0){
            return true;
        }
        return false;
    }
   
}
