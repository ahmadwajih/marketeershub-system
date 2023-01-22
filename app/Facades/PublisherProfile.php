<?php

namespace App\Facades;

use App\Charts\PublisherOfferProfileChart;
use App\Models\Offer;
use App\Models\Payment;
use App\Models\SallaAffiliate;
use Illuminate\Support\Facades\Facade;
use App\Models\SallaInfo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


class PublisherProfile extends Facade{

    // Get Registerd name of the component

    protected static function getFacadeAccessor()
    {
        return 'publisher-profile';
    }

    static function activeOffers($childrens, $where){
        $activeOffers = DB::table('pivot_reports')
        ->select(
                DB::raw('TRUNCATE(SUM(pivot_reports.orders),2) as orders'),
                DB::raw('TRUNCATE(SUM(pivot_reports.sales) ,2) as sales'),
                DB::raw('TRUNCATE(SUM(pivot_reports.revenue) ,2) as revenue'),
                'offers.id as offer_id',
                'offers.name_en as offer_name',
                'offers.status as offer_status',
                'offers.thumbnail as thumbnail',
                'offers.description_en as description',
                'offers.status as status',
                'offers.expire_date as expire_date',
                'pivot_reports.date as date',
                DB::raw('COUNT(coupons.id) as coupons')
            )
            ->join('coupons', 'pivot_reports.coupon_id', '=', 'coupons.id')
            ->join('offers', 'coupons.offer_id', '=', 'offers.id')
            ->join('users', 'coupons.user_id', '=', 'users.id')
            ->whereIn('coupons.user_id', $childrens)
            ->where($where)
            ->orderBy('date',  'DESC')
            ->groupBy('offer_name', 'date')
            ->get();

            return $activeOffers;
    }

    static function totalNumbers($childrens, $where){
        $totalNumbers = DB::table('pivot_reports')
            ->select(DB::raw('SUM(orders) as orders'), DB::raw('SUM(sales) as sales'), DB::raw('SUM(revenue) as revenue'), DB::raw('SUM(payout) as payout'))
            ->join('coupons', 'pivot_reports.coupon_id', '=', 'coupons.id')
            ->join('users', 'coupons.user_id', '=', 'users.id')
            ->whereIn('coupons.user_id', $childrens)
            ->where($where)
            ->orderBy('date',  'DESC')
            ->groupBy('date')
            ->first();

            return $totalNumbers;
    }

    static function offers($childrens){
        $offers = Offer::whereHas('coupons', function($q) use($childrens) {
            $q->whereIn('user_id', $childrens);
        })->with(['users' => function($q) use($childrens){
            $q->whereIn('users.id', $childrens);
        },
        'coupons' => function($q) use($childrens){
            $q->whereIn('coupons.user_id', $childrens);
        }])->get();

        return $offers;
    }

    static function offers_collection($childrens) {
        $offers = Offer::whereHas('coupons', function($q) use($childrens) {
            $q->whereIn('user_id', $childrens);
        })->with(['users' => function($q) use($childrens){
            $q->whereIn('users.id', $childrens);
        },
        'coupons' => function($q) use($childrens){
            $q->whereIn('coupons.user_id', $childrens);
        }]);

        return $offers;
    }

    static function coupons($childrens, $where){
        $coupons = DB::table('pivot_reports')
        ->select(
                DB::raw('TRUNCATE(SUM(pivot_reports.orders),2) as orders'),
                DB::raw('TRUNCATE(SUM(pivot_reports.sales) ,2) as sales'),
                DB::raw('TRUNCATE(SUM(pivot_reports.revenue) ,2) as revenue'),
                'coupons.id as id',
                'coupons.coupon as coupon',
                'offers.name_en as offer_name',
                'pivot_reports.date as date',
                DB::raw('COUNT(coupons.id) as coupons')
            )
            ->join('coupons', 'pivot_reports.coupon_id', '=', 'coupons.id')
            ->join('users', 'coupons.user_id', '=', 'users.id')
            ->join('offers', 'coupons.offer_id', '=', 'offers.id')
            ->whereIn('coupons.user_id', $childrens)
            ->where($where)
            ->orderBy('date',  'DESC')
            ->groupBy('coupon', 'date')
            ->get();

            return $coupons;
    }

    static function payments($childrens){
        $payments = Payment::whereHas('publisher', function ($q) use ($childrens) {
            $q->whereIn('publisher_id', $childrens);
        })->get();

        return $payments;
    }
}
