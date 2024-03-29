<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

/**
 * @method static whereId(\Illuminate\Contracts\Foundation\Application|\Illuminate\Session\SessionManager|\Illuminate\Session\Store|mixed $session)
 * @method static findOrFail(mixed $id)
 * @method static where(string $string, mixed $column)
 * @method static whereEmail(string $string)
 * @method static select(string $string)
 * @method static create(array $array)
 * @method static whereStatus(string $string)
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasRelationships;

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
    public function users()
    {
        return $this->hasMany(User::class, 'parent_id');
    }
    public function childrens(){
        // return $this->hasMany(User::class, 'parent_id');
        return $this->hasMany(User::class, 'parent_id')->with('childrens');
    }
    public function childrenss(){
        return DB::table('users as u')
        ->join('users as c', 'u.id', '=', 'c.parent_id')
        ->select('u.id')
        ->where('u.id', auth()->user()->id)
        ->pluck('id')->toArray();
        // return $this->hasMany(User::class, 'parent_id');
        return $this->hasMany(User::class, 'parent_id')->with('childrens');

    }

    public function assignRole($role_id)
    {
        return $this->roles()->save($role_id);
    }

    public function abilities()
    {
        return $this->roles->map->abilities->flatten()->pluck('name')->unique();
    }

    public function permissions()
    {
        return $this->hasManyDeep(
            Ability::class,
            ['role_user', Role::class, 'ability_role'], // Pivot tables/models starting from the Parent, which is the User
        );
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

    public function payments(){
        return $this->hasMany(Payment::class, 'publisher_id', 'id');
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
        return Str::plural(ucwords(str_replace('_', ' ', $this->attributes['team'])));
    }

    public function getUpdatedPositionAttribute(){
        return ucwords(str_replace('_', ' ', $this->attributes['position']));
    }

    public function getHumansCreatedAtAttribute(){
        return Carbon::parse($this->created_at)->diffForHumans();
    }

    public function socialMediaLinks(){
        return $this->hasMany(SocialMediaLink::class);
    }

    public function digitalAssets(){
        return $this->hasMany(DigitalAsset::class);
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

    public function getSumOrdersCountAttribute()
    {
        $orders = $this->coupons->map(function ($coupon){
            return $coupon->report()->whereMonth(
                'created_at', '>', Carbon::now()->subMonth()->month
            )->get();
        })->flatten();
        return $orders;

    }

    // public function getCreatedAtAttribute()
    // {
    //     return Carbon::createFromFormat('Y-m-d H:i:s', $this->attributes['created_at'])->format('Y-m-d');
    // }

    public function getSizeAttribute(){
        if($this->attributes['team'] == 'influencer' || $this->attributes['team'] == 'prepaid'){
            $sizes = [
                ''
            ];
            $size = [];
            foreach($this->socialMediaLinks as $link){
                return $size[]['platform'] = $link['platform'];
            }
        }
    }

    public function unSeenChats(){
        return $this->hasMany(Chat::class, 'sender_id', 'id')->where('receiver_id', auth()->user()->id)->where('seen', false);
    }
}
