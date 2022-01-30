<?php 

use Illuminate\Support\Facades\DB;
use App\Models\Coupon;


if(!function_exists('totalNumbersForSeparateTeam')){
    function totalNumbersForSeparateTeam($team){

        return DB::table('pivot_reports')
        ->select(DB::raw('SUM(orders) as orders'), DB::raw('SUM(sales) as sales'), DB::raw('SUM(revenue) as revenue'),  DB::raw('SUM(payout) as payout'))
        ->join('coupons', 'pivot_reports.coupon_id', '=', 'coupons.id')
        ->join('users', 'coupons.user_id', '=', 'users.id')
        ->where('users.team', '=', $team)
        ->orderBy('date', 'desc')
        ->groupBy('date')
        ->having('orders', '>', 0)
        ->first();
    }
}

if(!function_exists('totalNumbers')){
    function totalNumbers(){

        return DB::table('pivot_reports')
        ->select(DB::raw('SUM(orders) as orders'), DB::raw('SUM(sales) as sales'), DB::raw('SUM(revenue) as revenue'),  DB::raw('SUM(payout) as payout'))
        ->orderBy('date', 'desc')
        ->groupBy('date')
        ->having('orders', '>', 0)
        ->first();
    }
}

 // Team Performce Fucntions 
 if(!function_exists('publisherPerformanceBasedOnTeam')){
    function publisherPerformanceBasedOnTeam($team){

        return DB::table('pivot_reports')
        ->select
        (DB::raw('SUM(orders) as orders'), 
        DB::raw('SUM(revenue) as revenue'),  
        'users.name as user',
        'pivot_reports.date as date',
        )
        ->join('coupons', 'pivot_reports.coupon_id', '=', 'coupons.id')
        ->join('users', 'coupons.user_id', '=', 'users.id')
        ->where('users.team', '=', $team)
        ->orderBy('orders', 'desc')
        ->groupBy('user', 'date')
        ->having('orders', '>', 0)
        ->get();
    }
}


