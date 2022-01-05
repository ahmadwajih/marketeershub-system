<?php

namespace App\Models;
//161.35.27.113
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Offer extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $guarded = [];
    protected $append = [
        'name',
        'description',
        'note',
        'terms_and_conditions',
    ];

    // protected static $relations_to_cascade = ['coupons', 'newOld', 'slaps', 'categories', 'countries']; 

    // protected static function boot(){
    //     parent::boot();
    //     static::deleting(function($resource) {
    //         foreach (static::$relations_to_cascade as $relation) {
    //             foreach ($resource->{$relation}()->get() as $item) {
    //                 $item->delete();
    //             }
    //         }
    //     });

    //     static::restoring(function($resource) {
    //         foreach (static::$relations_to_cascade as $relation) {
    //             $resource->$relation()->withTrashed()->restore();
    //         }
            
    //     });

    //     static::forceDeleted(function($resource) {
    //         foreach (static::$relations_to_cascade as $relation) {
    //             $resource->$relation()->withTrashed()->forceDelete();
    //         }
    //     });
    // }


    public function getNameAttribute(){
        return $this->attributes['name_'. app()->getLocale()];
    }

    public function getDescriptionAttribute(){
        return $this->attributes['name_'. app()->getLocale()];
    }

    public function getNoteAttribute(){
        return $this->attributes['name_'. app()->getLocale()];
    }

    public function getTermsAndConditionAttribute(){
        return $this->attributes['name_'. app()->getLocale()];
    }


    public function advertiser(){
        return $this->belongsTo(Advertiser::class);
    }

    public function currency(){
        return $this->belongsTo(Currency::class);
    }
  
    public function coupons(){
        return $this->hasMany(Coupon::class);
    }

    public function countries(){
        return $this->belongsToMany(Country::class)->withTimestamps();
    }

    public function assignCountry($contry){
        return $this->countries()->save($contry);
    }

    public function unassignCountry($contry)
    {
        return $this->countries()->detach($contry);
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

    public function newOld(){
        return $this->hasOne(NewOldOffer::class);
    }

    public function slaps(){
        return $this->hasMany(OfferSlap::class);
    }

    public function users(){
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function report(){
        return $this->hasOne(PivotReport::class)->select(DB::raw('SUM(orders) as orders'), DB::raw('SUM(sales) as sales'), DB::raw('SUM(revenue) as revenue'),  DB::raw('SUM(payout) as payout'))->groupBy('date')->orderBy('date', 'desc');
        return $this->hasOne(PivotReport::class)
        ->select(
            DB::raw('SUM(orders) as orders'), 
            DB::raw('SUM(sales) as sales'), 
            DB::raw('SUM(revenue) as revenue'),  
            DB::raw('SUM(payout) as payout')
        )
        ->join('coupons', 'pivot_reports.coupon_id', '=', 'coupons.id')
        ->join('users', 'coupons.user_id', '=', 'users.id')
        ->where('pivot_reports.offer_id', '=', $this->id)
        ->groupBy('date')->orderBy('date', 'desc');
    }

    public function reportPerTeam($team){
        return $this->hasOne(PivotReport::class)
        ->select(
            DB::raw('SUM(orders) as orders'), 
            DB::raw('SUM(sales) as sales'), 
            DB::raw('SUM(revenue) as revenue'),  
            DB::raw('SUM(payout) as payout'))
            ->join('coupons', 'pivot_reports.coupon_id', '=', 'coupons.id')
            ->join('users', 'coupons.user_id', '=', 'users.id')
            ->where('users.team', '=', $team)
            ->groupBy('date')->orderBy('date', 'desc');
    }




}
