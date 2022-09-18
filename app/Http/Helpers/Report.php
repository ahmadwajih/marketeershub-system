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


 // User Performce Fucntions 
 if(!function_exists('userPerformance')){
    function userPerformance($user){

        $childrens = userChildrens($user);
        array_push($childrens, $user->id);
        return DB::table('pivot_reports')
        ->select(
            DB::raw('TRUNCATE(SUM(pivot_reports.orders),2) as orders'), 
            DB::raw('TRUNCATE(SUM(pivot_reports.sales) ,2) as sales'),
            DB::raw('TRUNCATE(SUM(pivot_reports.revenue) ,2) as revenue'),
            DB::raw('TRUNCATE(SUM(pivot_reports.payout) ,2) as payout'),
                'pivot_reports.date as date',
                'users.team as team',
                DB::raw('COUNT(coupons.id) as coupons')
            )
            ->join('offers', 'pivot_reports.offer_id', '=', 'offers.id')
            ->join('coupons', 'pivot_reports.coupon_id', '=', 'coupons.id')
            ->join('users', 'coupons.user_id', '=', 'users.id')
            ->whereIn('coupons.user_id', $childrens)
            ->first();
        
    }
}


if(!function_exists('totalOffersNumbers')){
    function totalOffersNumbers($offerId){

        return DB::table('pivot_reports')
        ->select(DB::raw('SUM(orders) as orders'), DB::raw('SUM(sales) as sales'), DB::raw('SUM(revenue) as revenue'),  DB::raw('SUM(payout) as payout'))
        ->where('pivot_reports.offer_id', $offerId)
        ->orderBy('date', 'desc')
        ->groupBy('date')
        ->having('orders', '>', 0)
        ->first();
    }
}


if(!function_exists('totalNumbersBasedOnTeamAndOffer')){
    function totalNumbersBasedOnTeamAndOffer($offerId){
        $data = DB::table('pivot_reports')
        ->select(
            DB::raw('SUM(pivot_reports.orders) as orders'),
            DB::raw('SUM(pivot_reports.sales) as sales'),
            DB::raw('SUM(pivot_reports.revenue) as revenue'),
            DB::raw('SUM(pivot_reports.payout) as payout'),
            'pivot_reports.date as date',
            'offers.id  as offer_id',
            'offers.name_en  as offer_name',
            'users.team as team'
        )
        ->join('offers', 'pivot_reports.offer_id', 'offers.id')
        ->join('coupons', 'pivot_reports.coupon_id', 'coupons.id')
        ->join('users', 'coupons.user_id', 'users.id')
        ->where('pivot_reports.offer_id', $offerId)
        // ->where('users.team', $team)
        ->groupBy('team')
        ->orderBy('team', 'desc')
        ->get();
        return $data->groupBy('date')->first();
    }
}

