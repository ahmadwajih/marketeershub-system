<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\Coupon;
use App\Models\Currency;
use App\Models\Offer;
use App\Models\PivotReport;
use App\Models\PublisherCategory;
use App\Models\User;
use App\Notifications\NewOffer;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(){

        $this->authorize('view_dashboard');

        // Get all offers that have coupons and report
        $offers  = Offer::whereHas('report')->with(['report'])->get();    

        $totalNumbers = DB::table('pivot_reports')
        ->select(DB::raw('SUM(orders) as orders'), DB::raw('SUM(sales) as sales'), DB::raw('SUM(revenue) as revenue'),  DB::raw('SUM(payout) as payout'))
        ->orderBy('date', 'desc')
        ->groupBy('date')
        ->first();

        return view('admin.index', [
            'offers' => $offers,
            'totalNumbers' => $totalNumbers,
            'totalInfluencerNumbers' => totalNumbersForSeparateTeam('influencer'),
            'totalAffiliateNumbers' => totalNumbersForSeparateTeam('affiliate'),
            'totalMediaBuyingNumbers' => totalNumbersForSeparateTeam('media_buying'),
        ]);

        return view('admin.index');
    }


    public function changeLang($lang){
        session(['lang' => $lang]);
        return redirect()->back();
    }

    // Charts
    public function chartGmVPo()
    {
        $data = [
            'series' => [
                [
                    'name' => 'Net Profit',
                    'data' => [44, 55, 57, 56, 61, 58, 63, 60, 66],
                ], [
                    'name' => 'Revenue',
                    'data' => [76, 85, 101, 98, 87, 105, 91, 114, 94],
                ],
            ],
            'chartOptions' => [
                'chart' => [
                    'height' => 350,
                    'type' => 'bar',
                ],
                'legend' => [
                    'position' => 'top'
                ],
                'plotOptions' => [
                    'bar' => [
                        'horizontal' => false,
                        'columnWidth' => '55%',
                        'endingShape' => 'rounded'
                    ],
                ],
                'dataLabels' => [
                    'enabled' => false
                ],
                'stroke' => [
                    'show' => true,
                    'width' => 2,
                    'colors' => ['transparent']
                ],
                'xaxis' => [
                    'categories' => [''],
                ],
            ],
        ];
        return response()->json($data, 200);
    }

    public function chartOffersMarketShare()
    {
        $offers = Offer::whereHas('coupons', function($q)  {
            $q->whereHas('report');
        })->get();


        $data = [
            'series' => [75, 25],
            'chartOptions' => [
                'labels' => $offers->pluck('name')->toArray(),
                'chart' => [
                    'width' => 680,
                    'type' => 'pie',
                ],
                'legend' => [
                    'position' => 'bottom'
                ],
                'stroke' => [
                    'show' => false,
                ],
            ],
        ];
        return response()->json($data);
    }


    public function test(){

        
        $totalNumbers = DB::table('offers')
        ->join('coupons', 'offers.id', '=', 'coupons.offer_id')
        ->join('pivot_reports', 'coupons.id', '=', 'pivot_reports.coupon_id')
        ->select(DB::raw('pivot_reports.orders, (SELECT pivot_reports.sales FROM pivot_reports  WHERE pivot_reports.coupon_id = coupons.id) AS orders '))

        // ->select('offers.name_en', DB::raw('IFNULL(pivot_reports.orders, 0) as orders'), DB::raw('IFNULL(pivot_reports.sales, 0) as sales'), DB::raw('IFNULL(pivot_reports.revenue, 0) as revenue'), DB::raw('IFNULL(pivot_reports.payout, 0) as payout'))
        ->orderBy('pivot_reports.date', 'desc')
        ->get();

        dd($totalNumbers);




      
        $totalNumbers = DB::table('pivot_reports')
        ->join('coupons', 'pivot_reports.coupon_id', '=', 'coupons.id')
        ->join('users', 'coupons.user_id', '=', 'users.id')
        ->join('offers', 'coupons.offer_id', '=', 'offers.id')
        ->select('offers.name_en', DB::raw('IFNULL(pivot_reports.orders, 0) as orders'), DB::raw('IFNULL(pivot_reports.sales, 0) as sales'), DB::raw('IFNULL(pivot_reports.revenue, 0) as revenue'), DB::raw('IFNULL(pivot_reports.payout, 0) as payout'))
        ->orderBy('pivot_reports.date', 'desc')
        // ->where('users.team', '=', $team)
        ->first();
            dd( json_decode(json_encode($totalNumbers), true) );



        // $report = PivotReport::get()[0];
        // $report->forceDelete();
        dd(PivotReport::get()[0]);
    }
}
