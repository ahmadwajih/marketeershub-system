<?php 

use Illuminate\Support\Facades\DB;
use App\Models\Coupon;


if(!function_exists('totalNumbersForSeparateTeam')){
    function totalNumbersForSeparateTeam($team){

        return DB::table('pivot_reports')
        ->join('coupons', 'pivot_reports.coupon_id', '=', 'coupons.id')
        ->join('users', 'coupons.user_id', '=', 'users.id')
        ->select(DB::raw('IFNULL(orders, 0) as orders'), DB::raw('IFNULL(sales, 0) as sales'), DB::raw('IFNULL(revenue, 0) as revenue'), DB::raw('IFNULL(payout, 0) as payout'))
        ->orderBy('pivot_reports.date', 'desc')
        ->where('users.team', '=', $team)
        ->first();
    }
}
if(!function_exists('coutValuesBasedOnTeam')){
    function coutValuesBasedOnTeam($offerId, $team){
        return DB::table('pivot_reports')
            ->join('coupons', 'pivot_reports.coupon_id', '=', 'coupons.id')
            ->join('users', 'coupons.user_id', '=', 'users.id')
            ->select(DB::raw('IFNULL(orders, 0) as orders'), DB::raw('IFNULL(sales, 0) as sales'), DB::raw('IFNULL(revenue, 0) as revenue'), DB::raw('IFNULL(payout, 0) as payout'))
            ->where('users.team', '=', $team)
            ->where('coupons.offer_id', '=', $offerId)
            ->orderBy('pivot_reports.date', 'desc')
            ->first();
    }
}