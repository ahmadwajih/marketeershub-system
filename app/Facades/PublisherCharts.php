<?php 

namespace App\Facades;

use App\Charts\PublisherOfferProfileChart;
use App\Models\Offer;
use App\Models\SallaAffiliate;
use Illuminate\Support\Facades\Facade;
use App\Models\SallaInfo;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;


class PublisherCharts extends Facade{
     
    // Get Registerd name of the component

    protected static function getFacadeAccessor()
    {
        return 'publisher-charts';
    }

    protected static function colors($number){
        $colors = array_reverse(['#227093','#ee5253', '#222f3e', '#ff9f43', '#40407a', '#0abde3', '#1abc9c', '#2ecc71', '#2c2c54',  '#3498db', '#9b59b6', '#2c2c54', '#34495e', '#16a085', '##16a085', '#27ae60', '#2980b9', '#8e44ad', '#f1c40f', '#e67e22' ,'#c0392b']);
        $colorsNo = count($colors) - $number;
        $nededColors = array_reverse(array_slice($colors,$colorsNo));
        return $nededColors;
    }

    static function chart($object, $title, $chartFor, $chartType, $datasetTitle){
        $chart = new PublisherOfferProfileChart;
        $offersNames = $object->pluck($title);
        $data = $object->pluck($chartFor);
        $colors =  PublisherCharts::colors(count($data));
        
        $chart = new PublisherOfferProfileChart;
        $chart->labels($offersNames);
        $chart->dataset($datasetTitle,$chartType, $data)->backgroundColor($colors);
        return $chart;
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
            ->orderBy('orders',  'DESC')
            ->groupBy('offer_name', 'date')
            ->limit(5)
            ->get();
        
            return $activeOffers;
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
            ->orderBy('orders',  'DESC')
            ->groupBy('coupon', 'date')
            ->limit(5)
            ->get();
        
            return $coupons;
    }

}